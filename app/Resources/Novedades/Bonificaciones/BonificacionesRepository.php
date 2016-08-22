<?php namespace App\Resources\Novedades\Bonificaciones;

use App\Resources\Novedades\Models\Bonificacion;
use Bosnadev\Repositories\Eloquent\Repository;

class BonificacionesRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return Bonificacion
     */
    public function model()
    {
        return Bonificacion::class;
    }

    public function all($columns = array('*'))
    {
        return $this->model->periodoActual()->get();
    }

    public function create(array $data)
    {
        $bonificacion = parent::create([
            'cedula_empleado' => $data['cedula_empleado'],
            'valor' => $data['valor'],
            'por_remplazo' => $data['por_remplazo']
        ]);
        if($bonificacion){
            if($data['por_remplazo']){
                $bonificacion->detalles_remplazo()->create($data['detalles_remplazo']);
            }
        }
        return $bonificacion;
    }

    public function update(array $data, $id, $attribute = "id")
    {
        $bonificacion = $this->model->find($id);
        if(!array_key_exists('detalles_remplazo', $data)) $data['por_remplazo'] = false;
        $result = $bonificacion->update([
            'valor' => $data['valor'],
            'por_remplazo' => $data['por_remplazo']
        ]);
        if($result){
            if($data['por_remplazo']){
                $detalles = $bonificacion->detalles_remplazo()->firstOrNew(['bonificacion_id' => $bonificacion->id]);
                $detalles->cedula_empleado_remplazado = $data['detalles_remplazo']['cedula_empleado_remplazado'];
                $detalles->numero_de_dias = $data['detalles_remplazo']['numero_de_dias'];
                $bonificacion->detalles_remplazo()->save($detalles);
            } else {
                if($detalles_remplazo = $bonificacion->detalles_remplazo){
                    $detalles_remplazo->delete();
                }
            }
        }
        return $result;
    }

}