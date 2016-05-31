<?php
/**
 * Created by tav0
 * Date: 5/05/16
 * Time: 07:53 PM
 */

namespace App\Resources\Empleados\Models;


use App\Resources\Empleados\Models\Empleado;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    protected $table = 'certificados_laborales';
    public $incrementing = false;
    protected $fillable = [
        'id', 'cedula_empleado', 'fecha', 'tipo'
    ];

    public $timestamps = false;

    public $dates = ['fecha'];

    public function empleado()
    {
        $this->cedula_empleado = str_pad($this->cedula_empleado, 13);
        return $this->belongsTo(Empleado::class, 'cedula_empleado', 'codigo');
    }

}