<?php

declare(strict_types=1);

namespace RHo\Http\Filter;

class BigInt extends AbstractInteger
{

    public function __construct(mixed $value)
    {
        parent::__construct($value, PHP_INT_MIN, PHP_INT_MAX, '/^([\-\+]?)0*([0-9]{1,19})$/');
    }
}
