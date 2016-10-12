<?php namespace App\Resources\Novedades\Models;


use Dingo\Api\Exception\ResourceException;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $table = 'periodos';

    protected $fillable = [
        'fecha_inicio',
        'fecha_final',
        'numero',
        'fecha_cierre',
    ];

    protected $dates = ['fecha_inicio', 'fecha_final'];

    public function detalles_remplazo()
    {
        return $this->belongsTo(TipoBonificacion::class, 'bonificacion_id');
    }

    public function scopeActual($query)
    {
        $fechaactual = Date('Y-m-d');
        $periodo = $query->whereRaw("fecha_inicio <= '$fechaactual' AND fecha_final >= '$fechaactual'")->first();
        if(!$periodo) {
            throw new ResourceException('No existe un periodo para la fecha', ['E_NOTFOUND_PERIODO' => true]);
        }
        return $periodo;
    }
}