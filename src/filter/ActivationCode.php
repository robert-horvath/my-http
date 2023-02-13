<?php

declare(strict_types=1);

namespace RHo\Http\Filter;

class ActivationCode extends AbstractString
{

    public function __construct(mixed $value)
    {
        parent::__construct($value, 128, 128, '/^[A-Za-z0-9]{128}$/');
    }
}
