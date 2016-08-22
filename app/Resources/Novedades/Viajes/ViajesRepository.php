<?php namespace App\Resources\Novedades\Viajes;

use App\Resources\Novedades\Models\Viaje;
use Bosnadev\Repositories\Eloquent\Repository;

class ViajesRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return Viaje
     */
    public function model()
    {
        return Viaje::class;
    }

    public function all($columns = array('*'))
    {
        return $this->model->periodoActual()->get();
    }

    public function update(array $data, $id, $attribute = "id")
    {
        return parent::update(['valor' => $data['valor']], $id, $attribute);
    }

}