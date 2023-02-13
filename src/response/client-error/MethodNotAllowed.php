<?php

declare(strict_types=1);

namespace RHo\Http\Response;

class MethodNotAllowed extends AbstractResponse
{
    protected const STATUS_CODE = 405;
}
