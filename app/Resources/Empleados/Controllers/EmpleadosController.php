<?php
/**
 * Created by tav0
 * Date: 9/04/16
 * Time: 02:20 PM
 */

namespace App\Resources\Empleados\Controllers;


use App\Core\BaseController;
use App\Resources\Empleados\Repositories\EmpleadosRepository;
use App\Resources\Empleados\Transformers\EmpleadosTransformer;
use Illuminate\Support\Facades\DB;

/**
 * @Resource("Empleados", uri="/empleados")
 */
class EmpleadosController extends BaseController
{

    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return EmpleadosRepository::class;
    }

    /**
     * Obtener todos los empleados
     * @Get("/")
     */
    public function index()
    {
        $filters['distrito'] = $this->request->query('distrito', '');
        $filters['area'] = $this->request->query('area', '');
        $filters['vinculacion'] = $this->request->query('vinculacion', '');
        $filters['cargo'] = $this->request->query('cargo', '');
        $empleados = $this->repository->get($filters);
        return $this->response->collection($empleados, new EmpleadosTransformer);
    }

    public function show($cedula)
    {
        $empleado = $this->repository->find($cedula);
        if($empleado) {
            return $this->response->item($empleado, new EmpleadosTransformer);
        } else {
            return $this->response->noContent();
        }
    }
    
}