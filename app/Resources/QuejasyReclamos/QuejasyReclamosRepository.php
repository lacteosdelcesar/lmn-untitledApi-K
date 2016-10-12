<?php
/**
 * Created by tav0
 * Date: 8/04/16
 * Time: 09:41 AM
 */

namespace App\Resources\QuejasyReclamos;

use App\Resources\QuejasyReclamos\Models\SolicitudPQR;
use Bosnadev\Repositories\Eloquent\Repository;

class QuejasyReclamosRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return SolicitudPQR
     */
    public function model()
    {
        return SolicitudPQR::class;
    }

    /**
     * @param $cedula
     * @return SolicitudPQR
     */
    public function findLast($cedula)
    {
        return $this->model->where('cedula_empleado', $cedula)->orderBy('fecha', 'desc')->first();
    }

}