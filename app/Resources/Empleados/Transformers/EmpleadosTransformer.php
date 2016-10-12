<?php
/**
 * Created by tav0
 * Date: 15/04/16
 * Time: 1:17 PM
 */

namespace App\Resources\Empleados\Transformers;


use App\Resources\Empleados\Models\Empleado;
use League\Fractal\TransformerAbstract;

class EmpleadosTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['contrato', 'contratos'];

    public function transform(Empleado $empleado, $params = [])
    {
        $payload = [
            'cedula'    => $empleado->cedula,
            'nombre'    => $empleado->nombre,
            'apellidos' => $empleado->apellidos
        ];
        $empleado = $empleado->toArray();
        if(array_key_exists('salario', $empleado)) $payload['salario'] = $empleado['salario'];
        return $payload;
    }

    public function includeContrato(Empleado $empleado)
    {
        $contrato = $empleado->contrato;
        if($contrato){
            return $this->item($contrato, new ContratosTransformer);
        }
    }

    public function includeContratos(Empleado $empleado)
    {
        $contratos = $empleado->contratos;
        if(count($contratos)){
            return $this->collection($contratos, new ContratosTransformer);
        }
    }
}