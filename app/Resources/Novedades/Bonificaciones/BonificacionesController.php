<?php namespace App\Resources\Novedades\Bonificaciones;

use App\Core\BaseController;
use App\Resources\Novedades\Models\Periodo;

class BonificacionesController extends BaseController
{
    /**
     * @return BonificacionesRepository
     */
    protected function repository()
    {
        return BonificacionesRepository::class;
    }

    public function index()
    {
        $bonificaciones = $this->repository->with(['empleado', 'empleado.salario', 'detalles_remplazo'])->all();
        if($bonificaciones) {
            return $this->response->collection($bonificaciones, new BonificacionesTransformer);
        } else {
            return $this->response->noContent();
        }
    }

    public function store()
    {
        $data = $this->request->all();

        $validator = \Validator::make($data, [
            'cedula_empleado' => 'required',
            'valor' => 'required',
            'por_remplazo' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorValidator($validator->messages());
        }

        $data['periodo_id'] = Periodo::actual()->id;

        if($this->repository->create($data)){
            return $this->response->created();
        } else {
            return $this->response->errorInternal('no se ha podido guardar el registro');
        }
    }

    public function update($id)
    {
        $validator = \Validator::make($this->request->all(), [
            'valor' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorValidator($validator->messages());
        }

        $data = $this->request->all();
        if($this->repository->update(['valor' => $data['valor']], $id)){
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
}