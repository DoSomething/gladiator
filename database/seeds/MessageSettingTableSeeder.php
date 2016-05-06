<?php

use Gladiator\Models\MessageSetting;
use Illuminate\Database\Seeder;

class MessageSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultMessages = correspondence()->defaults();

        foreach ($defaultMessages as $message) {
            $setting = new MessageSetting;
            $setting->type = $message['type'];
            $setting->key = $message['key'];
            $setting->label = $message['label'];
            $setting->subject = $message['subject'];
            $setting->body = $message['body'];
            $setting->pro_tip = $message['pro_tip'];
            $setting->signoff = $message['signoff'];
            $setting->save();
        }
    }
}
