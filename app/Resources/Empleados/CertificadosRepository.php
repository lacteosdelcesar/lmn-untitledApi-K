<?php
/**
 * Created by tav0
 * Date: 8/04/16
 * Time: 09:41 AM
 */

namespace App\Resources\Empleados;

use App\Models\Certificado;
use Bosnadev\Repositories\Eloquent\Repository;

class CertificadosRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Certificado::class;
    }
}