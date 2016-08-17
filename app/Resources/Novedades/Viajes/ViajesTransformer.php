<?php namespace App\Resources\Novedades\Viajes;


use App\Resources\Novedades\Models\Viaje;
use League\Fractal\TransformerAbstract;

class ViajesTransformer extends TransformerAbstract
{
    public function transform(Viaje $viaje)
    {
        $payload = [
            'empleado' => [
                'nombre' => $viaje->empleado->nombre,
                'apellidos' => $viaje->empleado->apellidos,
                'cedula' => $viaje->empleado->cedula,
            ],
            'valor' => $viaje->valor,
            'id' => $viaje->id,
        ];

        return $payload;
    }
}