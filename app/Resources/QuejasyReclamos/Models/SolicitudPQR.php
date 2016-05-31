<?php
/**
 * Created by tav0
 * Date: 24/05/16
 * Time: 01:43 PM
 */

namespace App\Resources\QuejasyReclamos\Models;


use App\Resources\Auth\Models\User;
use App\Resources\Empleados\Models\Empleado;
use Illuminate\Database\Eloquent\Model;

class SolicitudPQR extends Model
{
    protected $table = 'solicitudes_pqr';

    protected $fillable = [
        'cedula_empleado',
        'mensaje',
        'fecha',
        'respuesta',
        'fecha_respuesta',
        'usuario_que_responde'
    ];

    public $timestamps = false;

    public $dates = ['fecha', 'fecha_respuesta'];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'cedula_empleado');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_que_responde');
    }

    public function getCedulaEmpleadoAttribute($value)
    {
        return str_pad($value, 13);
    }
}