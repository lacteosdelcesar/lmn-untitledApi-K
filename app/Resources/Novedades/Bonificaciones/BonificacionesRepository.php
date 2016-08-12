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

}