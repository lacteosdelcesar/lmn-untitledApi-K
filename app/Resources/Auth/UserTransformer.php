<?php
/**
 * Created by tav0
 * Date: 9/04/16
 * Time: 10:24 PM
 */

namespace App\Resources\Auth;


use App\Resources\Auth\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $u)
    {
        $u->load('rol');
        $user = $u->toArray();
        unset($user['rol_id']);
        return $user;
    }
}