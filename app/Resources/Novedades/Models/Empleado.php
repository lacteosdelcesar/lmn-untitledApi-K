<?php namespace App\Resources\Novedades\Models;

class Empleado extends \App\Resources\Empleados\Models\Empleado
{

    public function jornadas()
    {
        return $this->hasMany(JornadaLaboral::class, 'cedula_empleado', 'codigo')->where('periodo_id', Periodo::actual()->id);
    }

}