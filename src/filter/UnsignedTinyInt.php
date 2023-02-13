<?php

declare(strict_types=1);

namespace RHo\Http\Filter;

class UnsignedTinyInt extends AbstractInteger
{

    public function __construct(mixed $value)
    {
        parent::__construct($value, 0, 255, '/^([\-\+]?)0*([0-9]{1,3})$/');
    }
}
