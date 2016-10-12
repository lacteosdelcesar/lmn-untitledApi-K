<?php namespace App\Resources\Novedades\Models;


use Illuminate\Database\Eloquent\Model;

class DetallesBonificacion extends Model
{
    protected $table = 'detalle_bonificacion_remplazo';

    protected $primaryKey = 'bonificacion_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'bonificacion_id',
        'cedula_empleado_remplazado',
        'numero_de_dias'
    ];
}