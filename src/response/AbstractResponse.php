<?php

declare(strict_types=1);

namespace RHo\Http\Response;

use RHo\Http\ResponseInterface;

abstract class AbstractResponse implements ResponseInterface
{
    protected const STATUS_CODE = -1;

    public function __construct(
        private readonly array $headers = [],
        private readonly string $body = ''
    ) {
    }

    public function send(): void
    {
        $this->sendHeaders();
        $this->sendBody();
        $this->sendResponseCode();
    }

    private function sendHeaders(): void
    {
        foreach ($this->headers as $key => $value)
            header("$key: $value");
    }

    private function sendBody(): void
    {
        echo $this->body;
    }

    private function sendResponseCode(): void
    {
        http_response_code(static::STATUS_CODE);
    }
}
