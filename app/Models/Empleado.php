<?php
/**
 * Created by tav0
 * Date: 6/04/16
 * Time: 11:53 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{

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