<?php

namespace Gladiator\Services\Settings;

use Symfony\Component\HttpKernel\Exception\HttpException;

class SettingCategoryNotFoundException extends HttpException
{
    /**
     * Make a new Setting Category Not Found exception.
     */
    public function __construct()
    {
        parent::__construct(404, 'Setting Category Not Found');
    }
}
