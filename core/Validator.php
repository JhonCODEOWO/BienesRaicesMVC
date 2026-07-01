<?php

namespace Core;

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

    public function required(mixed $input, $param = null): bool{
        return (isset($input) && $input != null && $input != "");
    }

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
                $inputValue = $this->data[$field] ?? null; //Input value from data.
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

    public function invalid(): bool {
        return $this->errors->hasErrors();
    }
}