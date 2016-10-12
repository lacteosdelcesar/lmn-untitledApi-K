<?php namespace App\Resources\Novedades\Models;


use Illuminate\Database\Eloquent\Model;

class IntervalosJornadaLegal extends Model
{
    protected $table = 'intervalos_jornada_legal';

    public $timestamps = false;

    public static function get()
    {
        return static::first();
    }
}