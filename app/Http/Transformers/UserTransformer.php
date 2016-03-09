<?php

namespace Gladiator\Http\Transformers;

use Gladiator\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * Transform resource data.
     *
     * @param  User  $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => (string) $user->id,
            'first_name' => null,
            'last_name' => null,
            'email' => null,
            'mobile' => null,
            'signup' => null,
            'reportback' => null,
        ];
    }
}
