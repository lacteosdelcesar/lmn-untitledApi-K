<?php
/**
 * Created by tav0
 * Date: 5/05/16
 * Time: 01:13 PM
 */

namespace App\Resources\Empleados\Controllers;


use App\Core\BaseController;
use App\Resources\Empleados\Models\Distrito;

class DistritosController extends BaseController
{
    public function index()
    {
      $distritos = Distrito::whereNotIn('codigo', ['XXX', '   '])->get();
      return $this->response->array($distritos->toArray());
    }

}
