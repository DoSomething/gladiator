<?php

namespace Gladiator\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UnauthorizedAccessException extends HttpException
{
    /**
     * Make a new Unauthorized Access exception.
     */
    public function __construct()
    {
        parent::__construct(401, 'Unauthorized access.');
    }
}
