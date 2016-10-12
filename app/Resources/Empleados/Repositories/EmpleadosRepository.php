<?php
/**
 * Created by tav0
 * Date: 8/04/16
 * Time: 09:41 AM
 */

namespace App\Resources\Empleados\Repositories;

use App\Resources\Empleados\Models\Empleado;
use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class EmpleadosRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Empleado::class;
    }

    public function find($cedula, $columns = array('*'))
    {
        $cedula  = str_pad($cedula, 13);
        return parent::find($cedula, $columns);
    }

    /**
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function get($filters = array())
    {
        $query = $this->applyFilters($this->model, $filters);
        return $query->get();
    }

    /**
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    private function applyFilters($query, array $filters)
    {
        $distrito = array_key_exists('distrito', $filters) ? $filters['distrito'] : '';
        $area = array_key_exists('area', $filters) ? $filters['area'] : '';
        $vinculacion = array_key_exists('vinculacion', $filters) ? $filters['vinculacion'] : '';
        $cargo = array_key_exists('cargo', $filters) ? $filters['cargo'] : '';
        $query->whereHas('contrato', function ($q) use($distrito, $area, $vinculacion, $cargo) {
            if ($distrito) {
                $q->where('id_co', '=', $distrito);
            }
            if ($area) {
                $area = str_pad($area, 8);
                $q->where('id_ccosto', '=', $area);
            }
            if ($vinculacion) {
                $q->where('id_emp', '=', $vinculacion);
            }
            if ($cargo) {
                $q->where('id_cargo', '=', $cargo);
            }
        });
        return $query;
    }
}