<?php namespace App\Resources\Novedades\Models;


use Illuminate\Database\Eloquent\Model;

class Bonificacion extends Novedad
{
    protected $table = 'bonificaciones';

    protected $fillable = [
        'id',
        'cedula_empleado',
        'periodo_id',
        'valor',
        'por_remplazo',
    ];

    protected $casts = ['valor' => 'float', 'por_remplazo' => 'boolean'];

    public function detalles_remplazo()
    {
        return $this->hasOne(DetallesBonificacion::class);
    }
}