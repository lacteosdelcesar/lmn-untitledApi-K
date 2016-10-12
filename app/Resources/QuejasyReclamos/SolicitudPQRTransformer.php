<?php
/**
 * Created by tav0
 * Date: 15/04/16
 * Time: 1:17 PM
 */

namespace App\Resources\QuejasyReclamos;


use App\Resources\Empleados\Transformers\EmpleadosTransformer;
use App\Resources\QuejasyReclamos\Models\SolicitudPQR;
use League\Fractal\TransformerAbstract;

class SolicitudPQRTransformer extends TransformerAbstract
{
    public function transform(SolicitudPQR $solicitud)
    {

        $payload = [
            'empleado' => [
                'nombre' => $solicitud->empleado->nombre_completo,
                'cedula' => $solicitud->empleado->cedula
            ],
            'mensaje' => $solicitud->mensaje,
            'fecha' => $solicitud->fecha,
            'respuesta' => $solicitud->respuesta,
            'fecha_respuesta' => $solicitud->fecha_respuesta,
            'id' => $solicitud->id
        ];
        $usuario = $solicitud->usuario;
        if($usuario){
            $payload['usuario_que responde'] = $usuario->username;
        }

        return $payload;
    }
}