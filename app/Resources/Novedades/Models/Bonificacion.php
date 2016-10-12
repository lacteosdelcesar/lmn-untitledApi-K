<?php namespace App\Resources\Novedades\Models;


use Illuminate\Database\Eloquent\Model;

class Bonificacion extends Model
{
    use Novedad;

    protected $table = 'bonificaciones';

    protected $fillable = [
        'cedula_empleado',
        'periodo_id',
        'valor',
        'por_remplazo',
    ];

    protected $casts = ['valor' => 'float', 'por_remplazo' => 'boolean'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function detalles_remplazo()
    {
        return $this->hasOne(DetallesBonificacion::class);
    }
}