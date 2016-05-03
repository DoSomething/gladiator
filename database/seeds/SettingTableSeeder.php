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

        // Call additional settings specific seeder methods.
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

            $settingSubject = new Setting;
            $settingSubject->category = 'messages';
            $settingSubject->group = $message['type'] . '_' . $message['key'];
            $settingSubject->key = $message['type'] . '_' . $message['key'] . '_subject';
            $settingSubject->value = $message['subject'];
            $settingSubject->meta_data = Settings::serializeData([
                'field_label' => 'subject',
                'field_type' => 'text',
            ]);
            $settingSubject->save();

            $settingBody = new Setting;
            $settingBody->category = 'messages';
            $settingBody->group = $message['type'] . '_' . $message['key'];
            $settingBody->key = $message['type'] . '_' . $message['key'] . '_body';
            $settingBody->value = $message['body'];
            $settingBody->meta_data = Settings::serializeData([
                'field_label' => 'body',
                'field_type' => 'textarea',
            ]);
            $settingBody->save();
        }
    }
}
