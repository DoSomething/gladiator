<?php

namespace Gladiator\Services\Northstar\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class NorthstarUserNotFoundException extends HttpException
{
    /**
     * Make a new Northstar User exception.
     */
    public function __construct()
    {
        parent::__construct(404, 'Northstar user was not found.');
    }
}
