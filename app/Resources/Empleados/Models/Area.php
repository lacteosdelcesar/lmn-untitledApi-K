<?php
/**
 * Created by tav0
 * Date: 6/04/16
 * Time: 11:53 PM
 */

namespace App\Resources\Empleados\Models;

use App\Resources\Empleados\Models\Lib\OModel;

class Area extends OModel
{
    
    protected $connection = 'oracle';
    protected $table = 'centro_costo';
    protected $primaryKey = 'codigo';
    public $incrementing = false;
    public $timestamps = false;

    protected $queryable = ['codigo', 'descripcion'];

    public function getDescripcionAttribute($value)
    {
        return trim($value);
    }
}