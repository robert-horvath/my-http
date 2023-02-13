<?php

declare(strict_types=1);

namespace RHo\Http\Response;

class BadRequest extends AbstractResponse
{
    protected const STATUS_CODE = 400;
}
