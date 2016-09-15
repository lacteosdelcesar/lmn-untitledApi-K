<?php namespace App\Resources\Novedades\Models;


use Illuminate\Database\Eloquent\Model;

class HorasJornada extends Model
{
    protected $table = 'horas_jornada';

    protected $primaryKey = 'jornada_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'jornada_id',
        'tipo',
        'tiempo'
    ];
}