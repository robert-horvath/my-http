<?php

declare(strict_types=1);

namespace RHo\Http;

class ResponseBuilder implements ResponseBuilderInterface
{
    private StatusCode $statusCode;
    private array $headers;
    private string $body;

    public function init(StatusCode $statusCode): self
    {
        $this->statusCode = $statusCode;
        $this->headers = [];
        $this->body = '';
        return $this;
    }

    public function withHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function withBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    public function build(): ResponseInterface
    {
        $class = __NAMESPACE__ . '\\Response\\' . $this->statusCode->name;
        return new $class($this->headers, $this->body);
    }
}
