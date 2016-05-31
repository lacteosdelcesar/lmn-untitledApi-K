<?php
/**
 * Created by tav0
 * Date: 9/04/16
 * Time: 08:34 PM
 */

namespace App\Resources\Auth\Controllers;


use App\Core\BaseController;
use App\Resources\Auth\UserRepository;
use App\Resources\Auth\UserTransformer;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{

    protected function repository()
    {
        return UserRepository::class;
    }

    public function create()
    {
        $validator = \Validator::make($this->request->all(), [
            'nombre' => 'required|unique:users',
            'password' => 'required',
            'rol_id' => 'required',
        ], [
            'nombre.unique' => 'Nombre de usuario ya registrado',
        ]);
        if ($validator->fails()) {
            return $this->errorValidator($validator->messages());
        }

        $user = $this->repository->create($this->request->all());
        
        // Registered Event
        $token = \Auth::fromUser($user);
        return $this->response->array(['token' => $token]);
    }

    public function show()
    {
        $user = $this->user();
        return $this->response->item($user, new UserTransformer());
    }

    function changePassword()
    {
        $user = $this->user();
        $data = $this->request->all();
        if($user = $this->repository->checkUser(['username' => $user->username, 'password' => $data['password']])){
            $user->password = Hash::make($data['new_password']);
            if($user->save()){
                return $this->response->array(['mensaje' => 'contraseña actualizada']);
            } else {
                return $this->response->errorInternal('no se pudo actualizar la contraseña');
            }
        } else {
            $this->response->errorUnauthorized();
        }
    }
}