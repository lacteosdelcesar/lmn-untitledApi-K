<?php namespace App\Resources\Novedades\JornadasLaborales;


use App\Resources\Novedades\Models\Empleado;
use League\Fractal\TransformerAbstract;

class JornadasTransformer extends TransformerAbstract
{
    public function transform(Empleado $empleado)
    {
        $payload = [
            'empleado' => [ 'nombre' => $empleado->nombre_completo, 'cedula' => $empleado->cedula ],
            'horas' => ['ho' => 0, 'rn' => 0, 'ed' => 0, 'en' => 0, 'fo' => 0,
                        'efd' => 0, 'efn' => 0, 'ttl' => 0, 'dias' => 0]
        ];

        if($jornada = $empleado->jornadas->first()){
            $payload['id'] = $jornada->id;
            $payload['hora_entrada1'] = $jornada->hora_entrada1;
            $payload['hora_salida1'] = $jornada->hora_salida1;
            $payload['hora_entrada2'] = $jornada->hora_entrada2;
            $payload['hora_salida2'] = $jornada->hora_salida2;
            foreach ($jornada->horas as $h) {
                $payload['horas'][$h->tipo] = floatval($h->tiempo);
            }
        }

        return $payload;
    }
}