<?php

declare(strict_types=1);

namespace RHo\Http\Filter;

class UnsignedSmallInt extends AbstractInteger
{

    public function __construct(mixed $value)
    {
        parent::__construct($value, 0, 65535, '/^([\-\+]?)0*([0-9]{1,5})$/');
    }
}
