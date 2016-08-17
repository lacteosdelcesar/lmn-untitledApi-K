<?php namespace App\Resources\Novedades\Viajes;

use App\Resources\Novedades\Models\Viaje;
use App\Resources\Novedades\Models\Periodo;
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

    public function create(array $data)
    {
        $data['periodo_id'] = Periodo::actual()->id;
        return parent::create($data);
    }

    public function update(array $data, $id, $attribute = "id")
    {
        return parent::update(['valor' => $data['valor']], $id, $attribute);
    }

}