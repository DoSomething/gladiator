<?php

use Gladiator\Models\Setting;
use Gladiator\Services\Settings\Settings;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedMessagesSettings();

        // Add additional settings seeders
    }

    /**
     * Seed the messages settings category.
     *
     * @return void
     */
    protected function seedMessagesSettings()
    {
        $defaultMessages = correspondence()->defaults();

        foreach($defaultMessages as $message) {
            $setting = new Setting;
            $setting->category = 'messages';
            $setting->key = $message['type'] . '_' . $message['key'];
            $setting->value = Settings::serializeData($message);
            $setting->serialized = true;
            $setting->save();
        }
    }
}
