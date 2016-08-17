<?php namespace App\Resources\Novedades\Models;


use Illuminate\Database\Eloquent\Model;

class Viaje extends Model
{
    use Novedad;

    protected $table = 'viajes';

    protected $fillable = [
        'cedula_empleado',
        'periodo_id',
        'valor',
    ];

    protected $casts = ['valor' => 'float'];

}