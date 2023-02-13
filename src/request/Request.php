<?php

declare(strict_types=1);

namespace RHo\Http;

class Request implements RequestInterface
{
    private readonly array $uriParts;

    public function __construct(private readonly array $server)
    {
        $this->uriParts = explode('/', $this->uri());
    }

    public function isHttpsScheme(): bool
    {
        return ($this->server['HTTPS'] ?? 'off') === 'on';
    }

    public function isWwwHost(): bool
    {
        return strtolower(substr(($this->server['HTTP_HOST'] ?? ''), 0, 3)) === 'www';
    }

    public function uriPart(int $index): string
    {
        return $this->uriParts[$index];
    }

    public function isUriMatch(string $pattern, array &$matches): bool
    {
        $matches = null;
        $uri = $this->server['REQUEST_URI'] ?? '';
        return preg_match($pattern, $uri, $matches) === 1;
    }

    public function method(): string
    {
        return $this->server['REQUEST_METHOD'] ?? '';
    }

    public function uri(): string
    {
        return $this->server['REQUEST_URI'] ?? '';
    }

    public function headers(): array
    {
        return getallheaders();
    }
}
