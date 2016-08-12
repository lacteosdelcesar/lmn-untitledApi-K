<?php namespace App\Resources\Novedades\Models;


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

    public function detalles_remplazo()
    {
        return $this->belongsTo(TipoBonificacion::class, 'bonificacion_id');
    }

    public function scopeActual($query)
    {
        $fechaactual = Date('Y-m-d');
        return $query->whereRaw("fecha_inicio <= '$fechaactual' AND fecha_final >= '$fechaactual'")->get()->first();
    }
}