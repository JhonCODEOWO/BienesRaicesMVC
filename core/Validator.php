<?php

namespace Core;

use Error;
use Exception;

class Validator {
    /**
     *  All data to be validated where `key` is the field name and `value` the content to validate
     */
    private array $data = [];
    /**
     *  Validation rules to evaluate each value in `$data` property where `key` is the field name and `value`
     *  a array of associative arrays with `name`, `value` keys where `name` value contains the name of a rule
     *  and `value` the params to include in each rule.
     * @example
     *  [
     *      "fullname" => [
     *          ["name"=>'required', "value" => null],
     *          ["name"=>'minLength', "value" => "15"],
     *       ],
     *      "phone_number" => [
     *          ["name"=>'required', "value" => null],
     *          ["name"=>'minLength', "value" => "10"],
     *       ],
     *  ]
     */
    private array $validationRules = [];
    /**
     * A fresh instance of Errors to add every error of Validator instance.
     */
    protected Errors $errors;
    /**
     *  All error messages to use for every rule available to evaluate in this class
     *  if you need add more edit config/ValidationMessages.php file or change the file path in constructor.
     */
    protected array $errorMessages = [];

    public function __construct(array $data, ?array $validationRules = [])
    {
        $this->data = $data;
        $this->errors = new Errors();
        $this->validationRules = $this->mapInputValidationRules($validationRules);
        $this->errorMessages = include __DIR__ .'/../config/ValidationMessages.php';
    }
    
    /**
     *  Transform the array input from constructor in a new array with the `$validationRules` property array format.
     *
     * @param  mixed $inputValidationRules
     * @return array
     */
    private function mapInputValidationRules(array $inputValidationRules) : array{
        $validRules = [];
        foreach ($inputValidationRules as $inputName => $stringRules) {
            //Separate each rule
            $typedRules = explode('|', $stringRules);

            //Add every type rule group by input name with params.
            foreach ($typedRules as $index => $stringRule) {
                $ruleSegments = explode(':', $stringRule);
                $ruleName = $ruleSegments[0];
                $params = $ruleSegments[1] ?? null;

                $validRules[$inputName][] = [
                    "name" => $ruleName,
                    "value" => $params,
                ];
            }
        }
        return $validRules;
    }
    
    /**
     *  Checks if the value passed has a valid value and is filled with something.
     *
     * @param  mixed $input The value to check.
     * @param  mixed $param
     * @return bool
     */
    public function required(mixed $input, $param = null): bool{
        if(is_array($input)) return count($input) != 0;
        return (isset($input) && $input != null && $input != "");
    }
    
    /**
     *  Checks if the input file contains a valid file instance and is a valid uploaded file.
     *
     * @param  mixed $array The array with all UploadedFile instances.
     * @param  mixed $param Rule param, not needed.
     * @return bool
     */
    public function file(array $array, $param = null) : bool{
        if(count($array) > 1) throw new Error("You are using rule file in a multiple file field, use files instead.");
        $file = $array[0];
        return $file instanceof UploadedFile && is_uploaded_file($file->getTmpName());
    }
    
    /**
     *  Checks the size of uploaded files are valid in the range defined by the param of the rule.
     *
     * @param  mixed $files
     * @param  mixed $param
     * @return bool
     */
    public function maxSize(mixed $files, $param = null): bool{
        $state = true;
        $bytes = $param * 1048576;
        foreach ($files as $file) {
            if(!($file instanceof UploadedFile)) continue;
            
            if($file->getSize() > $bytes) {
                $state = false;
                break;
            }
        }

        return $state;
    }

    //TODO: Validator of multiple files.
    public function min(mixed $input, mixed $minValue): bool{
        return ($input >= $minValue);
    }

    public function minLength(mixed $input, string $length): bool {
        $type = gettype($input);
        switch ($type) {
            case 'array':
                return (count($input) >= $length);
            
            default:
                return (strlen($input) >= $length);
        }
    }
    
    /**
     *  Exec validation rules of the validator instance for each field value.
     *
     * @return Errors A errors instance to interact with them.
     */
    public function validate() : Errors{
        foreach ($this->validationRules as $field => $rules) {
            foreach ($rules as $index => $rule) {
                $inputValue = $this->getInputValue($field); //Input value from data.

                //Rule info for each Input registered.
                $ruleFnName = $rule['name'];
                $ruleParam = $rule['value'];
                
                if(!method_exists($this, $ruleFnName)) throw new Exception("Validation rule $ruleFnName doesn't exists yet");

                $result = $this->$ruleFnName($inputValue, $ruleParam);

                if(!$result){
                    $this->errors->add($this->errorValidation($field, $ruleFnName, $ruleParam), $field);
                }
            }
        }
        return $this->errors;
    }
    
    /**
     *  Pick a error message from the current ValidationErrors.php file and returns the formatted string
     *  with field name and the needed value.
     *
     * @param  string $field
     * @param  string $rule
     * @param  string | null $paramVal
     * @return string The error validation rule.
     */
    private function errorValidation(string $field, string $rule, string | null $paramVal): string{
        $errorMessage = $this->errorMessages[$rule] ?? null;

        return str_replace(
            [":field", ":value"],
            [$field, $paramVal],
            $errorMessage
        );
    }

        
    /**
     *  Retrieves a value based on the arg provided
     * 
     *  inputs: files.imagen | username | profile.name | users.0.name
     *  output: The respective value from the data.
     *
     * @param  string $path A Input name or a path to get values from associative arrays.
     * @return mixed
     */
    private function getInputValue(string $path) : mixed{
        $pathSegments = explode('.', $path);
        $value = $this->data; //Value to return, re-assigned only if the path is valid.

        foreach ($pathSegments as $index => $segmentValue) {
            if (!is_array($value)) {
                throw new Error("Cannot access $segmentValue on non-array value.");
            }
            if(!array_key_exists($segmentValue, $value)) throw new Error("The segment $segmentValue provided in path doesn't exists.");
            
            $value = $value[$segmentValue];
        }
        return $value;
    }

    public function invalid(): bool {
        return $this->errors->hasErrors();
    }
}