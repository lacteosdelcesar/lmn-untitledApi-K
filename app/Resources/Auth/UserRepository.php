<?php
/**
 * Created by tav0
 * Date: 9/04/16
 * Time: 10:41 PM
 */

namespace App\Resources\Auth;


use App\Resources\Auth\Models\Rol;
use App\Resources\Auth\Models\User;
use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\Hash;

class UserRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return User::class;
    }

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return parent::create($data);
    }

    public function findRol($nombre)
    {
        return Rol::where('nombre', $nombre)->first();
    }

    public function checkUser($credentials)
    {
        if($user = $this->findBy('username', $credentials['username'])){
            if(Hash::check($credentials['password'], $user->password)){
                $user->load('rol');
                return $user;
            }
        }
        return false;
    }
}