<?php
/**
 * Created by tav0
 * Date: 6/04/16
 * Time: 11:53 PM
 */

namespace App\Resources\Empleados\Models;

use App\Resources\Empleados\Models\Lib\OModel;
use Illuminate\Support\Facades\DB;

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
    
    public function getTipoAttribute()
    {
        return ($this->fecha_cont_ha == '99999999') ? 'a término indefinido' : 'a término fijo';
    }

    public function getIdTercAttribute($value)
    {
        return substr($value, 0, 13);
    }

    public function getSalarioPromedioAttribute()
    {
        $sql = 'select * from('.
                'select lapso_doc, sum(nmmov_valor) as valor from nmresumen_pagos_nomina '.
                'where id_terc = ? and id_ind_dev_ded = 1 and id_tipo_doc = \'NQ\' '.
                'and  id_cpto != 673 group by lapso_doc order by lapso_doc desc '.
                ') where rownum <= 3';
        $pagos = DB::connection('oracle')->select($sql, [substr($this->id_terc, 0, 13)]);
        $sum = 0;
        foreach ($pagos as $pago) {
            $sum += $pago->valor;
        }
        return ($sum>0) ? $sum/count($pagos) : 0;
    }
}