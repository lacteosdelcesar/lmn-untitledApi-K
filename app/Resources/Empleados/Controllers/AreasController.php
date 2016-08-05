<?php
/**
 * Created by tav0
 * Date: 5/05/16
 * Time: 01:13 PM
 */

namespace App\Resources\Empleados\Controllers;


use App\Core\BaseController;
use App\Resources\Empleados\Models\Area;

class AreasController extends BaseController
{
    public function get()
    {
      $areas = Area::where('nivel_i', ' 1')
          ->whereNotIn('codigo', ['CIERRE  ', 'SINCCOST'])
          ->with('subAreas')->orderBy('descripcion')->get();
      return $this->response->array($areas->toArray());
    }

}
