<?php

declare(strict_types=1);

namespace RHo\Http\Filter;

class UnsignedInt extends AbstractInteger
{

    public function __construct(mixed $value)
    {
        parent::__construct($value, 0, 4294967295, '/^([\-\+]?)0*([0-9]{1,10})$/');
    }
}
