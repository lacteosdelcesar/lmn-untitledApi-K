<?php namespace App\Resources\Novedades\Bonificaciones;


use App\Resources\Novedades\Models\Bonificacion;
use League\Fractal\TransformerAbstract;

class BonificacionesTransformer extends TransformerAbstract
{
    public function transform(Bonificacion $bonificacion)
    {
        $payload = [
            'empleado' => [
                'nombre' => $bonificacion->empleado->nombre,
                'apellido' => $bonificacion->empleado->apellidos,
                'cedula' => $bonificacion->empleado->cedula,
                'salario' => $bonificacion->empleado->salario,
            ],
            'valor' => $bonificacion->valor,
            'por_remplazo' => $bonificacion->por_remplazo,
            'id' => $bonificacion->id,
        ];

        if($bonificacion->detalles_remplazo){
            $payload['detalles_remplazo'] = $bonificacion->detalles_remplazo->toArray();
        }

        return $payload;
    }
}