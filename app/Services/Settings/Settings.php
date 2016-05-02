<?php

namespace Gladiator\Services\Settings;

class Settings
{
    public static function serializeData($data)
    {
        return collect($data)->toJson();
    }

    public static function unserializeData($data)
    {
        return json_decode($data, true);
    }
}
