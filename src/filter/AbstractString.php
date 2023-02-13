<?php

declare(strict_types=1);

namespace RHo\Http\Filter;

abstract class AbstractString implements \RHo\Http\FilterInterface
{
    private readonly ?int $err;

    public function __construct(
        protected readonly mixed $value,
        private readonly int $minLength,
        private readonly int $maxLength,
        private readonly string $pattern
    ) {
    }

    final public function validate(): ?int
    {
        $this->err = $this->runAllFilters();
        return $this->err;
    }

    protected function runAllFilters(): ?int
    {
        if (!$this->isDataTypeValid())
            return self::ERR_DATA_TYPE;

        if (!$this->isMinSizeValid())
            return self::ERR_STR_TOO_SHORT;

        if (!$this->isMaxSizeValid())
            return self::ERR_STR_TOO_LONG;

        if (!$this->isSyntaxValid())
            return self::ERR_INVALID_SYNTAX;

        return NULL;
    }

    final public function value(): string
    {
        if ($this->err !== NULL)
            throw new \LogicException('Cannot access not valid value!');
        return $this->value;
    }

    private function isDataTypeValid(): bool
    {
        return is_string($this->value);
    }

    private function isMinSizeValid(): bool
    {
        return strlen($this->value) >= $this->minLength;
    }

    private function isMaxSizeValid(): bool
    {
        return strlen($this->value) <= $this->maxLength;
    }

    private function isSyntaxValid(): bool
    {
        return preg_match($this->pattern, $this->value) === 1;
    }
}
