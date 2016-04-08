<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Empleado;
use Monolog\Handler\ZendMonitorHandler;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function showall()
    {
        return Empleado::all();
    }

    public function show($codigo)
    {
        $empleado = Empleado::whereRaw("codigo = '$codigo'")->first();
//        foreach ($empleados as $empleado) {
//            $empleado->contratos;
//        }
        //$contratos = Contrato::whereRaw("id_terc = '$codigo'")->get();;
        return $empleado->contratos;
    }
}
