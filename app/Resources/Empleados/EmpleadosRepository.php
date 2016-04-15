<?php
/**
 * Created by tav0
 * Date: 8/04/16
 * Time: 09:41 AM
 */

namespace App\Resources\Empleados;

use App\Models\Empleado;
use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Support\Collection;
use Illuminate\Container\Container as App;

class EmpleadosRepository  extends Repository
{
    /**
     * EmpleadosRepository constructor.
     */
    public function __construct(App $app, Collection $collection)
    {
        parent::__construct($app, $collection);
        $this->model->setConnection('oracle');
    }


    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Empleado::class;
    }

    public function findBy($attribute, $value, $columns = array('*'))
    {
        $this->applyCriteria();
        return $this->model->whereRaw("$attribute = $value")->first($columns);
    }
}