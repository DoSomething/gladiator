<?php

namespace Gladiator\Http\Utilities;

use Gladiator\Repositories\UserRepositoryContract;


class Email
{


    public static function prepareMessage($message, $model)
    {
        //@TODO: I only tested this with competition, is there other things we want to replace?
        $tokens = $model::$tokenizable;
        foreach ($tokens as $token) {
            $message->body = str_replace(':'.$token, $model->$token, $message->body);
        }

        return $message;
    }
    // I moved this into it's own function b/c I figured this has to run for every users
    // whereas the message is probably? the same for everyone
    // this might not be true.
    // Message, and the model should probably be user or userrepocontract?
    public static function prepareSubject($message, $model)
    {
        $tokens = $model::$tokenizable;
        foreach ($tokens as $token) {
            $message->subject = str_replace(':'.$token, $model->$token, $message->subject);
        }

        return $message;
    }
}
