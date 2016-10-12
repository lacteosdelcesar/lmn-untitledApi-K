<?php
/**
 * Created by tav0
 * Date: 5/05/16
 * Time: 01:13 PM
 */

namespace app\Resources\Empleados\Controllers;


use App\Core\BaseController;
use App\Resources\Auth\UserRepository;
use App\Resources\Empleados\Models\Empleado;

class SyncController extends BaseController
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return UserRepository::class;
    }

    public function up()
    {
        $empleadoOrdinario = $this->repository->findRol('EMPL_ORD')->id;
        $empleadoTemporal = $this->repository->findRol('EMPL_TEMP')->id;
        $empleadoInactivo = $this->repository->findRol('EMPL_INACTIVO')->id;

        $empleados = Empleado::with('contrato')->get();

        $count_nuevos = 0;
        $count_actualizados = 0;
        $count_total = count($empleados);

        foreach($empleados as $empleado){
            if($empleado->contrato){
                // el empleado esta vinclado directamente con klarens
                if($empleado->contrato->vinculacion->codigo == '01') {
                    $rol = $empleado->contrato->estado == 'R' ? $empleadoInactivo : $empleadoOrdinario;
                } else {
                    $rol = $empleadoTemporal;
                }

                // si el empleado ya tiene un usuario, actualizo el rol si cambio
                if($usuario = $this->repository->findBy('username', $empleado->cedula)){
                    if($usuario->rol_id != $rol){
                        $usuario->rol_id = $rol;
                        $usuario->save();
                        ++$count_actualizados;
                    }
                }
                // si no, creo un nuevo usuario
                else {
                    $this->repository->create([
                        'username' => $empleado->cedula,
                        'password' => $empleado->cedula,
                        'rol_id' => $rol
                    ]);
                    ++$count_nuevos;
                }
            }
        }

        return $this->response->array([
            'empleados_agregados' => $count_nuevos,
            'empleados_actualizados' => $count_actualizados,
            'total_empleados' => $count_total
        ]);
    }

}