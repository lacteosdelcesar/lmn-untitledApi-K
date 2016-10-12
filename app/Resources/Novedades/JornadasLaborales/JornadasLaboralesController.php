<?php namespace App\Resources\Novedades\JornadasLaborales;

use App\Core\BaseController;
use App\Resources\Novedades\Models\JornadaLaboral;
use App\Resources\Novedades\Models\Periodo;

class JornadasLaboralesController extends BaseController
{
    /**
     * @return JornadasRepository
     */
    protected function repository()
    {
        return JornadasRepository::class;
    }

    public function index()
    {
        if($cedula = $this->request->query('empleado')) {
            $jornadasCollection = $this->indexByEmpleado($cedula);
        } else {
            $fecha = $this->request->query('fecha', date('Y-m-d'));
            $jornadasCollection = $this->indexByFecha($fecha);
        }

        return $jornadasCollection ? : $this->response->noContent();
    }

    public function indexByFecha($fecha)
    {
        $jornadas = $this->repository->getEmpleadosJornadasfecha($fecha);
        return $jornadas ? $this->response->collection($jornadas, new JornadasTransformer) : false;
    }

    public function indexByEmpleado($cedula)
    {
        $jornadas = $this->repository->all()->where('cedula_empleado', $cedula)->get();
        return $jornadas ? $this->response->collection($jornadas, new DiaDiaTransformer) : false;
    }

    public function indexHoras()
    {
        $empleados = $this->repository->getEmpleadosJornadasPeriodoActual();
        if($empleados) {
            return $this->response->collection($empleados, new TotalHorasEmpleadoTransformer);
        } else {
            return $this->response->noContent();
        }
    }

    public function store()
    {
        $validator = $this->valiate();
        if ($validator->fails()) {
            return $this->errorValidator($validator->messages());
        }

        $data = $this->request->only([
            'cedula_empleado',
            'hora_entrada1',
            'hora_salida1',
            'hora_entrada2',
            'hora_salida2',
            'fecha'
        ]);

        if($this->repository->create($data)){
            return $this->response->created();
        } else {
            return $this->response->errorInternal('no se ha podido guardar el registro');
        }
    }

    public function update($id)
    {
        $validator = $this->valiate();
        if ($validator->fails()) {
            return $this->errorValidator($validator->messages());
        }

        $data = $this->request->only([
            'cedula_empleado',
            'hora_entrada1',
            'hora_salida1',
            'hora_entrada2',
            'hora_salida2'
        ]);

        if($this->repository->update($data, $id)){
            return $this->response->accepted();
        } else {
            return $this->response->errorInternal('no se pudo actualizar el valor de la bonificacion');
        }
    }

    public function destroy($id)
    {
        if($this->repository->delete($id)){
            return $this->response->array(['mensaje' => 'registro eliminado']);
        } else {
            return $this->response->errorInternal('no se pudo eliminar el registro');
        }
    }

    private function valiate()
    {
        $fecha_final = Periodo::actual()->fecha_final->addDay();
        $fecha_inicio = Periodo::actual()->fecha_inicio->subDay();
        return \Validator::make($this->request->all(), [
            'cedula_empleado' => 'required|numeric',
            'hora_entrada1' => 'required|date_format:H:i',
            'hora_salida1' => 'required|date_format:H:i',
            'fecha' => "after:$fecha_inicio|before:$fecha_final"
        ]);
    }

}