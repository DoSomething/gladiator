<?php

namespace Gladiator\Services\Settings;

use Gladiator\Models\Setting;

class SettingRepository
{
    public function getAllByCategory($category, $unserializeData = false)
    {
        $data = Setting::where('category', $category)->get();

        if (! $data->count()) {
            throw new SettingCategoryNotFoundException;
        }

        if ($unserializeData) {
            foreach ($data as $item) {
                $item->value = Settings::unserializeData($item->value);
            }
        }

        return $data;
    }
}
