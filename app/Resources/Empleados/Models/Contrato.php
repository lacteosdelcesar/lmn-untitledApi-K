<?php
/**
 * Created by tav0
 * Date: 6/04/16
 * Time: 11:53 PM
 */

namespace App\Resources\Empleados\Models;

use App\Resources\Empleados\Models\Lib\OModel;

class Contrato extends OModel
{
    
    protected $connection = 'oracle';
    protected $table = 'contratos';
    protected $primaryKey = 'codigo';
    public $incrementing = false;
    public $timestamps = false;
    public $with = ['vinculacion', 'distrito', 'area'];

    protected $queryable = [
        'codigo',
        'salario',
        'fecha_ingreso',
        'fecha_retiro',
        'fecha_cont_ha',
        'estado',
        'id_terc',
        'id_emp',
        'id_co',
        'id_ccosto',
        'id_cargo'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_terc', 'codigo');
    }

    public function vinculacion()
    {
        return $this->belongsTo(Empresa::class, 'id_emp', 'codigo');
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'id_co', 'codigo');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_ccosto', 'codigo');
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'id_cargo', 'codigo');
    }
}