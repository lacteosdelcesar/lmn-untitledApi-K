<?php
/**
 * Created by tav0
 * Date: 9/04/16
 * Time: 02:20 PM
 */

namespace App\Resources\Empleados\Controllers;


use App\Core\Controllers\BaseController;
use App\Resources\Empleados\EmpleadosRepository;

class EmpleadosController extends BaseController
{
    public function repository()
    {
        return EmpleadosRepository::class;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->repository->all();
    }

    public function show($cedula)
    {
        return $this->repository->findBy('codigo', $cedula);
    }
}