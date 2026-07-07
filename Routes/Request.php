<?php 

namespace Routes;

use Core\UploadedFile;

class Request {
    /** Array with all url params in the request */
    private array $urlParams = [];
    /** Array with all query params in the request */
    private array $queryParams = [];
    /** Request method  */
    private string $method = '';
    /** Body request */
    private array $body = [];
    private array $files = [];

    public function __construct(array $args, ?array $files)
    {
        $this->urlParams = $args["urlParams"] ?? [];
        $this->queryParams = $args["queryParams"] ?? [];
        $this->method = $args['method'] ?? '';
        $this->body = $args["body"] ?? [];
        $this->files = $this->toUploadedFilesArray($files) ?? [];
    }

    // =========================
    // URL PARAMS
    // =========================

    public function getUrlParamValue(string $key): string|null
    {
        return $this->urlParams[$key] ?? null;
    }

    public function urlParams(): array
    {
        return $this->urlParams;
    }

    // =========================
    // QUERY PARAMS
    // =========================

    public function getQueryParam(string $key): string|null
    {
        return $this->queryParams[$key] ?? null;
    }

    public function queryParams(): array
    {
        return $this->queryParams;
    }

    // =========================
    // BODY
    // =========================

    public function getBodyValue(string $key): mixed
    {
        return $this->body[$key] ?? null;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function body(): array {
        return array_merge($this->getBody(), ["files" => $this->files]);
    }

    // =========================
    // METHOD
    // =========================

    public function method(): string
    {
        return $this->method;
    }

    // =========================
    // HELPERS
    // =========================

    public function all(): array
    {
        return [
            'urlParams' => $this->urlParams,
            'queryParams' => $this->queryParams,
            'body' => $this->body,
        ];
    }

    public function getFile(string $fileInputName): array{
        return $this->files[$fileInputName];
    }

    public function toUploadedFilesArray(array $files): array {
        $uploadedFiles = [];
        foreach ($files as $inputFieldName => $filesData) {
            if(!is_array($filesData['name'])){
                $uploadedFiles[$inputFieldName][] = new UploadedFile(
                    $filesData['name'],
                    $filesData['tmp_name'],
                    $filesData['error'],
                    $filesData['type'],
                );
                break;
            };
            
            foreach ($filesData['name'] as $index => $name) {
                $uploadedFiles[$inputFieldName][$index] = new UploadedFile(
                    $name,
                    $filesData['tmp_name'][$index],
                    $filesData['error'][$index],
                    $filesData['type'][$index],
                );
            }
        }
        return $uploadedFiles;
    }
}