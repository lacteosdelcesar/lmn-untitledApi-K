<?php
/**
 * Created by tav0
 * Date: 6/04/16
 * Time: 11:53 PM
 */

namespace App\Resources\Empleados\Models;

use App\Resources\Auth\Models\User;
use App\Resources\Empleados\Models\Lib\OModel;

class Area extends OModel
{

    protected $connection = 'oracle';
    protected $table = 'centro_costo';
    protected $primaryKey = 'codigo';
    public $incrementing = false;
    public $timestamps = false;

    protected $queryable = ['codigo', 'descripcion', 'codigo_niv_1'];

    public function subAreas()
    {
      return $this->hasMany(Area::class, 'codigo_niv_1', 'codigo')
            ->where('nivel_i', '!=', ' 1');
    }

    public function areas()
    {
        return $this->belongsToMany(User::class);
    }

    public function getDescripcionAttribute($value)
    {
        return trim($value);
    }
}
