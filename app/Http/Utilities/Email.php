<?php

namespace Gladiator\Http\Utilities;

class Email
{


    public static function prepareMessage($message, $model)
    {
        //@TODO: I only tested this with competition, is there other things we want to replace?
        $tokens = $model::$tokenizable;
        foreach ($tokens as $token) {
            $message->body = str_replace(':'.$token, $model->$token, $message->body);
                //@TODO: handle the message subject.
        }
        // dd($email);
        return $message;
    }

}
