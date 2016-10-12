<?php
/**
 * Created by tav0
 * Date: 15/04/16
 * Time: 1:17 PM
 */

namespace App\Resources\Empleados\Transformers;


use App\Resources\Empleados\Models\Contrato;
use League\Fractal\TransformerAbstract;

class ContratosTransformer extends TransformerAbstract
{

    public function transform(Contrato $contrato)
    {
        $payload = [
            'codigo' => $contrato->codigo,
            'salario' => $contrato->salario,
            'fecha_ingreso' => $contrato->fecha_ingreso,
            'fecha_retiro' => $contrato->fecha_retiro,
            'fecha_finalizacion' => $contrato->fecha_cont_ha,
            'estado' => $contrato->estado,
//            'cargo' => $contrato->cargo->toArray(),
            'vinculacion' => $contrato->vinculacion->toArray(),
            'distrito' => $contrato->distrito->toArray(),
            'area' => $contrato->area->toArray(),
        ];

        return $payload;
    }
}