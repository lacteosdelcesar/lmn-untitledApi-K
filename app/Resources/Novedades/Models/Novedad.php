<?php namespace App\Resources\Novedades\Models;


use App\Resources\Empleados\Models\Empleado;

trait Novedad
{

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'cedula_empleado');
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    public function scopePeriodo($query, $p_id)
    {
        return $query->where('periodo_id', $p_id);
    }

    public function scopePeriodoActual($query)
    {
        return $query->where('periodo_id', Periodo::actual()->id);
    }

    public function getCedulaEmpleadoAttribute($value)
    {
        return str_pad($value, 13);
    }
}