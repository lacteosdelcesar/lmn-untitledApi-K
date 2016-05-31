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
        $limit = $this->request->query('limit', 10);
        $empleados = $this->repository->get($limit, $filters);
        return $this->response->paginator($empleados, new EmpleadosTransformer);
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

    public function test()
    {
        $resul= DB::connection('oracle')->select("SELECT  T.CODIGO AS CEDULA,
                T.APELLIDO1,
                T.APELLIDO2,
                T.NOMBRES,
                C.SALARIO,
                EMP.DESCRIPCION AS VINCULACION,
                EMP.CODIGO AS EMPRESA_ID,
                CO.DESCRIPCION AS DISTRITO,
                CO.CODIGO AS DISTRITO_ID,
                CC.DESCRIPCION AS AREA,
                CC.CODIGO AS AREA_ID
        FROM    TERCEROS T
                JOIN CONTRATOS C
                ON      T.CODIGO=C.ID_TERC
                JOIN EMPRESAs EMP
                ON      EMP.CODIGO=C.ID_EMP
                JOIN CENTRO_OPERACION CO
                ON      CO.CODIGO=C.ID_CO
                JOIN CENTRO_COSTO CC
                ON      CC.CODIGO=C.ID_CCOSTO
        WHERE   T.ESTADO =' '
                AND T.IND_EMPL   ='1' ORDER BY T.CODIGO");
        echo print_r($resul);
    }
    
}