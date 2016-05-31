<?php
/**
 * Created by tav0
 * Date: 9/04/16
 * Time: 08:34 PM
 */

namespace App\Resources\QuejasyReclamos;


use App\Core\BaseController;
use App\Resources\Empleados\Models\Empleado;

class QuejasyReclamosController extends BaseController
{

    /**
     * @return QuejasyReclamosQRRepository
     */
    protected function repository()
    {
        return QuejasyReclamosRepository::class;
    }

    public function index()
    {
        $solicitudes = $this->repository->with(['usuario', 'empleado'])->all();
        if($solicitudes) {
            return $this->response->collection($solicitudes, new SolicitudPQRTransformer);
        } else {
            return $this->response->noContent();
        }
    }

    public function store($cedula)
    {
        $data = $this->request->all();
        $data['cedula_empleado'] = $cedula;
        $data['fecha'] = new \DateTime();

        $validator = \Validator::make($data, [
            'mensaje' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorValidator($validator->messages());
        }

        if($queja = $this->repository->create($data)){
            return $this->response->created();
        } else {
            return $this->response->errorInternal('no se pudo almacenar la solicitud');
        }
    }

    public function setRespuesta($id)
    {
        $validator = \Validator::make($this->request->all(), [
            'respuesta' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorValidator($validator->messages());
        }

        $data = $this->request->all();
        $data['fecha_respuesta'] = new \DateTime();
        $data['usuario_que_responde'] = $this->user()->id;

        if($queja = $this->repository->update($data, $id)){
            return $this->response->array(['mensaje' => 'solicitud actualizada', 'data' => $queja]);
        } else {
            return $this->response->errorInternal('no se pudo actualizar la solicitud');
        }
    }

    public function show($id)
    {
        $solicitud = $this->repository->with(['usuario', 'empleado'])->find($id);
        if($solicitud) {
            return $this->response->item($solicitud, new SolicitudPQRTransformer);
        } else {
            return $this->response->noContent();
        }
    }

    public function showLast($cedula)
    {
        $solicitud = $this->repository->findLast($cedula);
        if($solicitud) {
            return $this->response->item($solicitud, new SolicitudPQRTransformer);
        } else {
            return $this->response->noContent();
        }
    }

    public function destroy($id)
    {
        if($this->repository->delete($id)){
            return $this->response->arrya(['mensaje' => 'solicitud eliminada']);
        } else {
            return $this->response->errorInternal('no se pudo eliminar la solicitud');
        }
    }
}