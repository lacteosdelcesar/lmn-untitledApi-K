<?php
/**
 * Created by tav0
 * Date: 6/04/16
 * Time: 11:53 PM
 */

namespace App\Resources\Empleados\Models;

use App\Resources\Empleados\Models\Lib\OModel;
use App\Resources\Empleados\Models\Relations\HasOneContrato;
use App\Resources\QuejasyReclamos\Models\SolicitudPQR;
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
            $builder->distinct()->where('ind_empl', '=', 1);
        });
    }

    public function contrato()
    {
        return $this->hasOneContrato(Contrato::class, 'id_terc', 'codigo')
            ->orderBy('fecha_ingreso', 'desc');
    }

    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'id_terc', 'codigo');
    }

    public function salario()
    {
        return $this->hasOneContrato(Salario::class, 'id_terc', 'codigo')
            ->orderBy('fecha_ingreso', 'desc');
    }

    public function solicitudes()
    {
        return $this->hasMany(SolicitudPQR::class, 'cedula_empleado', 'codigo');
    }

    public function getCedulaAttribute()
    {
        return trim($this->codigo);
    }

    public function getCodigoAttribute($value)
    {
        return str_pad($value, 13);
    }

    public function getNombreAttribute()
    {
        return trim($this->nombres);
    }

    public function getApellidosAttribute()
    {
        return trim($this->apellido1).' '.trim($this->apellido2);
    }

    public function getNombreCompletoAttribute()
    {
        return trim($this->nombres).' '.trim($this->apellido1).' '.trim($this->apellido2);
    }

    public function hasOneContrato($related, $foreignKey = null, $localKey = null)
    {
        $foreignKey = $foreignKey ?: $this->getForeignKey();

        $instance = new $related;

        $localKey = $localKey ?: $this->getKeyName();

        return new HasOneContrato($instance->newQuery(), $this, $instance->getTable().'.'.$foreignKey, $localKey);
    }
}