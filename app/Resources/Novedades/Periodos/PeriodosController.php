<?php namespace App\Resources\Novedades\Periodos;

use App\Core\BaseController;
use App\Resources\Novedades\Models\Periodo;

class PeriodosController extends BaseController
{

    public function showActual()
    {
        $periodo = Periodo::actual();
        if($periodo) {
            return $this->response->array($periodo->toArray());
        } else {
            return $this->response->noContent();
        }
    }
}