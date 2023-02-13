<?php

declare(strict_types=1);

namespace RHo\Http\Filter;

class Password extends AbstractString
{

    public function __construct(mixed $value)
    {
        parent::__construct($value, 5, 32, '/^[^ ]{5,32}$/');
    }

    protected function runAllFilters(): ?int
    {
        $err = parent::runAllFilters();
        if ($err !== NULL)
            return $err;

        if (!$this->hasOneLowerChar())
            return self::ERR_PASSWORD_MISSING_LOWER_CHAR;

        if (!$this->hasOneUpperChar())
            return self::ERR_PASSWORD_MISSING_UPPER_CHAR;

        if (!$this->hasOneNumChar())
            return self::ERR_PASSWORD_MISSING_NUMBER_CHAR;

        return NULL;
    }

    private function hasOneLowerChar(): bool
    {
        return preg_match('/\p{Ll}+/', $this->value) === 1;
    }

    private function hasOneUpperChar(): bool
    {
        return preg_match('/\p{Lu}+/', $this->value) === 1;
    }

    private function hasOneNumChar(): bool
    {
        return preg_match('/[0-9]+/', $this->value) === 1;
    }
}
