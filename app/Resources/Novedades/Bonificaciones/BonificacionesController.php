<?php namespace App\Resources\Novedades\Bonificaciones;

use App\Core\BaseController;
use App\Resources\Novedades\Models\DetallesBonificacion;

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

        $validator = $this->valiate();
        if ($validator->fails()) {
            return $this->errorValidator($validator->messages());
        }

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

        $data = $this->request->all();
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
        return \Validator::make($this->request->all(), [
            'valor' => 'required',
            'por_remplazo' => 'boolean',
            'detalles_remplazo' => 'array',
            'detalles_remplazo.numero_de_dias' => 'numeric',
            'detalles_remplazo.cedula_empleado_remplazado' => 'numeric',
        ]);
    }
}