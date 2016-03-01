<?php

namespace Gladiator\Services\Northstar\Exceptions;

use Exception;

class NorthstarUserNotFoundException extends Exception
{
    /**
     * Make a new Northstar User exception.
     */
    public function __construct()
    {
        parent::__construct('Northstar user was not found.');
    }
}
