<?php namespace App\Resources\Novedades\Viajes;

use App\Core\BaseController;
use App\Resources\Novedades\Models\DetallesBonificacion;

class ViajesController extends BaseController
{
    /**
     * @return ViajesRepository
     */
    protected function repository()
    {
        return ViajesRepository::class;
    }

    public function index()
    {
        $viajes = $this->repository->with(['empleado'])->all();
        if($viajes) {
            return $this->response->collection($viajes, new ViajesTransformer);
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
            return $this->response->errorInternal('no se pudo actualizar el valor');
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
            'valor' => 'required'
        ]);
    }
}