<?php

declare(strict_types=1);

namespace RHo\Http\Filter;

class UnsignedBigInt extends AbstractInteger
{

    public function __construct(mixed $value)
    {
        parent::__construct($value, 0, 18446744073709551615, '/^\+?0*([0-9]{1,20})$/');
    }
}
