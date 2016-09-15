<?php namespace App\Resources\Novedades\JornadasLaborales;


use App\Resources\Novedades\Models\JornadaLaboral;
use League\Fractal\TransformerAbstract;

class DiaDiaTransformer extends TransformerAbstract
{
    public function transform(JornadaLaboral $jornada)
    {
        $horas = [
            'ho' => 0, 'rn' => 0, 'ed' => 0, 'en' => 0, 'fo' => 0,
            'efd' => 0, 'efn' => 0, 'ttl' => 0, 'dias' => 0
        ];
        foreach ($jornada->horas as $h) {
            $horas[$h->tipo] = floatval($h->tiempo);
        }
        $payload = [
            'horas' => $horas,
            'hora_entrada1' => $jornada->hora_entrada1,
            'hora_salida1' => $jornada->hora_salida1,
            'hora_entrada2' => $jornada->hora_entrada2,
            'hora_salida2' => $jornada->hora_salida2,
            'fecha' => $jornada->fecha,
            'id' => $jornada->id,
            'cedula_empleado' => trim($jornada->cedula_empleado),
            'periodo_id' => $jornada->periodo_id
        ];
        return $payload;
    }
}