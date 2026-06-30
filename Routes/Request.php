<?php 

namespace Routes;

class Request {
    /** Array with all url params in the request */
    private array $urlParams = [];
    /** Array with all query params in the request */
    private array $queryParams = [];
    /** Request method  */
    private string $method = '';
    /** Body request */
    private array $body = [];

    public function __construct(array $args)
    {
        $this->urlParams = $args["urlParams"] ?? [];
        $this->queryParams = $args["queryParams"] ?? [];
        $this->method = $args['method'] ?? '';
        $this->body = $args["body"] ?? [];
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

    public function body(): array
    {
        return $this->body;
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
}