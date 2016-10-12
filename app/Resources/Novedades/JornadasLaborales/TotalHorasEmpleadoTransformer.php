<?php namespace App\Resources\Novedades\JornadasLaborales;


use App\Resources\Novedades\Models\Empleado;
use League\Fractal\TransformerAbstract;

class TotalHorasEmpleadoTransformer extends TransformerAbstract
{
    public function transform(Empleado $empleado)
    {
        $payload = [
            'ho' => 0, 'rn' => 0, 'ed' => 0, 'en' => 0, 'fo' => 0,
            'efd' => 0, 'efn' => 0, 'ttl' => 0, 'dias' => 0
        ];
        foreach ($empleado->jornadas as $jornada) {
            foreach ($jornada->horas as $h) {
                $payload[$h->tipo] = floatval($h->tiempo);
            }
            $payload['dias'] += 1;
        }
        $payload['empleado'] = [
            'nombre' => $empleado->nombre_completo,
            'cedula' => $empleado->cedula
        ];
        return $payload;
    }
}