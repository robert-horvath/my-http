<?php

declare(strict_types=1);

namespace RHo\Http\Filter;

class Email extends AbstractString
{

    public function __construct(mixed $value)
    {
        parent::__construct($value, 5, 256, '/^.+@.+\..+$/');
    }

    protected function runAllFilters(): ?int
    {
        $err = parent::runAllFilters();
        if ($err !== NULL)
            return $err;

        if (!$this->isSyntaxValid())
            return self::ERR_INVALID_SYNTAX;

        return NULL;
    }

    private function isSyntaxValid(): bool
    {
        return filter_var($this->value, FILTER_VALIDATE_EMAIL) !== FALSE;
    }
}
