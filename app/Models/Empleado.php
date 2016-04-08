<?php
/**
 * Created by tav0
 * Date: 6/04/16
 * Time: 11:53 PM
 */

namespace App\Models;

use Yajra\Oci8\Eloquent\OracleEloquent;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class Empleado extends OracleEloquent
{
    use Eloquence, Mappable;

    protected $connection = 'oracle';
    protected $table = 'terceros';
    protected $primaryKey = 'codigo';
    public $incrementing = false;
    public $timestamps = false;

    protected $visible = ['codigo', 'apellido1', 'apellido2', 'nombres', 'estado'];

    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'id_terc', 'codigo');
    }
}