<?php

namespace Gladiator\Services\Settings;

use Gladiator\Models\Setting;

class SettingRepository
{
    public function getAllByCategory($category, $grouped = true)
    {
        $items = Setting::where('category', $category)->get();

        if (! $items->count()) {
            throw new SettingCategoryNotFoundException;
        }

        foreach ($items as $item) {
            if ($item->meta_data) {
                $item->meta_data = (object) Settings::unserializeData($item->meta_data);
            }
        }

        if ($grouped) {
            return $items->groupBy('group');
        }

        return $items;
    }
}
