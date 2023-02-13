<?php

declare(strict_types=1);

namespace RHo\Http\Filter;

class FirstName extends AbstractString
{

    public function __construct(mixed $value)
    {
        parent::__construct($value, 2, 64, '/^[\p{L} \-_\']{2,64}$/u');
    }
}
