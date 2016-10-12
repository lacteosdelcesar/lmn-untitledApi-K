<?php namespace App\Resources\Novedades\Models;


use Illuminate\Database\Eloquent\Model;

class JornadaLaboral extends Model
{
    use Novedad;

    protected $table = 'jornadas_laboradas';
    protected $fillable = [
        'cedula_empleado',
        'periodo_id',
        'hora_entrada1',
        'hora_salida1',
        'hora_entrada2',
        'hora_salida2',
        'fecha'
    ];
    public $timestamps = false;
    protected $with = ['horas'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function horas()
    {
        return $this->hasMany(HorasJornada::class, 'jornada_id');
    }

}