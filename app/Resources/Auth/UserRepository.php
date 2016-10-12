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
     * @return User
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

    /**
     * @param $nombre
     * @return Rol
     */
    public function findRol($nombre)
    {
        return Rol::where('nombre', $nombre)->first();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function allRoles()
    {
        return Rol::all()->toArray();
    }

    /**
     * @param $credentials
     * @return bool|User
     */
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