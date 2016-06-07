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

    public function index()
    {
        $users = $this->repository->all();
        return $this->response->collection($users, new UserTransformer);
    }

    public function create()
    {
        $validator = \Validator::make($this->request->all(), [
            'username' => 'required|unique:users',
            'rol_id' => 'required',
        ], [
            'username.unique' => 'Nombre de usuario ya registrado',
        ]);
        if ($validator->fails()) {
            return $this->errorValidator($validator->messages());
        }

        $data = $this->request->all();
        $data['password'] = $data['username'];
        $user = $this->repository->create($data);
        $user->load('rol');
        return $this->response->array(['data' => $user]);
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

    function resetPassword($user_id)
    {
        $user = $this->repository->find($user_id);
        if($user){
            $user->password = Hash::make($user->username);
            if($user->save()){
                return $this->response->array(['mensaje' => 'contraseña actualizada']);
            } else {
                return $this->response->errorInternal('no se pudo actualizar la contraseña');
            }
        } else {
            $this->response->errorNotFound('no se encuentre el usuario');
        }
    }
    
    function getRoles()
    {
        return $this->response->array($this->repository->allRoles());
    }
}