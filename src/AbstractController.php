<?php

declare(strict_types=1);

namespace RHo\Http;

abstract class AbstractController implements ControllerInterface
{
    private readonly bool $requestValid;
    private readonly ?string $nextCtrlClassName;

    public function __construct(
        protected readonly RequestInterface $request,
        protected readonly ResponseBuilderInterface $responseBuilder
    ) {
    }

    public function isRequestValid(): bool
    {
        if (!isset($this->requestValid)) {
            $this->requestValid = $this->validateRequest();
        }
        return $this->requestValid;
    }

    protected function validateRequest(): bool
    {
        return $this->validateResource() === NULL;
    }

    private function validateResource(): ?ResponseBuilderInterface
    {
        return $this->isRouteExists() ? NULL :
            $this->responseBuilder->init(StatusCode::NotFound)
            ->withHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->withBody('resource not found');
    }

    public function isLastRoute(): bool
    {
        if (!$this->isRequestValid())
            return TRUE;
        return $this->nextCtrlClassName === NULL;
    }

    public function nextController(): ControllerInterface
    {
        return new $this->nextCtrlClassName(
            $this->request,
            $this->responseBuilder
        );
    }

    abstract protected function routingTable(): array;

    abstract protected function path(): string;

    protected function isRouteMatch(string $expectedPath, string $actualPath): bool
    {
        return $expectedPath === $actualPath;
    }

    private function isRouteExists(): bool
    {
        $path = $this->path();
        foreach ($this->routingTable() as $route => $ctrlClass) {
            if ($this->isRouteMatch($route, $path)) {
                $this->nextCtrlClassName = $ctrlClass;
                return TRUE;
            }
        }
        return FALSE;
    }

    public function sendResponse(): void
    {
        $this->responseBuilder->build()->send();
    }

    public function runService(): void
    {
        $this->responseBuilder->init(StatusCode::NotImplemented);
    }
}
