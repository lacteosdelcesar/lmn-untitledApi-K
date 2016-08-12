<?php
/**
 * Created by tav0
 * Date: 6/04/16
 * Time: 11:53 PM
 */

namespace App\Resources\Empleados\Models;

use App\Resources\Empleados\Models\Lib\OModel;

class Salario extends OModel
{
    
    protected $connection = 'oracle';
    protected $table = 'contratos';
    protected $primaryKey = 'codigo';
    public $incrementing = false;
    public $timestamps = false;

    protected $queryable = [
        'id_terc',
        'salario'
    ];
    
    public function getValorAttribute()
    {
        return ($this->salario);
    }

    public function getIdTercAttribute($value)
    {
        return substr($value, 0, 13);
    }

    public function toArray()
    {
        return $this->attributes['salario'];
    }

}