<?php
/**
 * Created by tav0
 * Date: 6/04/16
 * Time: 11:53 PM
 */

namespace App\Resources\Empleados\Models;

use App\Resources\Empleados\Models\Lib\OModel;
use Illuminate\Database\Eloquent\Builder;

class Empleado extends OModel
{

    protected $connection = 'oracle';
    protected $table = 'terceros';
    protected $primaryKey = 'codigo';
    public $incrementing = false;
    public $timestamps = false;

    protected $orderBy = ['apellido1'];
    protected $queryable = ['codigo', 'apellido1', 'apellido2', 'nombres'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('emp', function(Builder $builder) {
            $builder->where('ind_empl', '=', 1);
        });
    }

    public function contrato()
    {
        return $this->hasOne(Contrato::class, 'id_terc', 'codigo')
            ->orderBy('fecha_ingreso', 'desc');
    }

    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'id_terc', 'codigo');
    }

    public function getCedulaAttribute()
    {
        return trim($this->codigo);
    }

    public function getCodigoAttribute($value)
    {
        return str_pad($value, 15);
    }

    public function getNombreAttribute()
    {
        return trim($this->nombres);
    }

    public function getApellidosAttribute()
    {
        return trim($this->apellido1).' '.trim($this->apellido2);
    }
}