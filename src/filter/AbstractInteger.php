<?php

declare(strict_types=1);

namespace RHo\Http\Filter;

abstract class AbstractInteger implements \RHo\Http\FilterInterface
{
    private readonly ?int $err;
    private readonly int $intValue;

    public function __construct(
        private readonly mixed $value,
        private readonly int $minValue,
        private readonly int $maxValue,
        private readonly string $pattern
    ) {
    }

    final public function value(): int
    {
        if ($this->err !== NULL)
            throw new \LogicException('Cannot access not valid value!');
        return $this->intValue;
    }

    final public function validate(): ?int
    {
        $this->err = $this->runAllFilters();
        return $this->err;
    }

    private function runAllFilters(): ?int
    {
        if (!$this->isDataTypeValid())
            return self::ERR_DATA_TYPE;

        if (!$this->isSyntaxValid())
            return self::ERR_INVALID_SYNTAX;

        if (!$this->isMinValid())
            return self::ERR_INT_TOO_SMALL;

        if (!$this->isMaxValid())
            return self::ERR_INT_TOO_BIG;

        return NULL;
    }

    private function isDataTypeValid(): bool
    {
        return $this->isDataTypeInt() || $this->isDataTypeString();
    }

    private function isDataTypeString(): bool
    {
        return is_string($this->value);
    }

    private function isDataTypeInt(): bool
    {
        $x = is_int($this->value);
        if ($x)
            $this->intValue = $x;
        return $x;
    }

    private function isMinValid(): bool
    {
        return $this->intValue >= $this->minValue;
    }

    private function isMaxValid(): bool
    {
        return $this->intValue <= $this->maxValue;
    }

    private function isSyntaxValid(): bool
    {
        if (isset($this->intValue))
            return TRUE;

        if (preg_match($this->pattern, $this->value, $matches) !== 1)
            return FALSE;

        return $this->isStringANumber($matches[1], $matches[2]);
    }

    private function isStringANumber(string $sign, string $value): bool
    {
        $sign = ($sign === '-' ? '-' : '');
        $str = $sign . $value;
        $this->intValue = intval($str);
        return (string) $this->intValue === $str;
    }
}
