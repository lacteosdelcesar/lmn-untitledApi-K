<?php
/**
 * Created by tav0
 * Date: 9/04/16
 * Time: 10:41 PM
 */

namespace App\Resources\Auth;


use App\Models\Rol;
use App\Models\User;
use Bosnadev\Repositories\Eloquent\Repository;

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
        $data['password'] = app('hash')->make($data['password']);
        return parent::create($data);
    }

    public function findRol($nombre)
    {
        return Rol::where('nombre', $nombre)->first();
    }
}