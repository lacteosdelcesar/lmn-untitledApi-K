<?php
/**
 * Created by tav0
 * Date: 8/04/16
 * Time: 09:41 AM
 */

namespace App\Resources\Empleados;

use App\Resources\Empleados\Models\Empleado;
use Bosnadev\Repositories\Eloquent\Repository;
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

    public function get($limit = 10, $filters)
    {
        $query = Empleado::select(DB::raw('DISTINCT(codigo)'));
        $query = $this->applyFilters($query, $filters);
        return $query->distinct()->paginate($limit);
    }

    private function applyFilters($query, $filters)
    {
        $distrito = $filters['distrito'] ? $filters['distrito'] : '';
        $area = $filters['area'] ? $filters['area'] : '';
        $vinculacion = $filters['vinculacion'] ? $filters['vinculacion'] : '';
        $cargo = $filters['cargo'] ? $filters['cargo'] : '';
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