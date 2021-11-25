<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuardarEnlace;
use App\Models\Enlace;
use Illuminate\Database\QueryException;

class EnlaceController extends APIController
{
    private Enlace $enlace;

    public function __construct(Enlace $enlace)
    {
        $this->enlace = $enlace;
    }

    public function obtenerEnlaces()
    {
        $enlaces = Enlace::all();
        return $this->respond($enlaces);
    }

    public function crear(GuardarEnlace $request)
    {
        try {
            $this->enlace->fill($request->validated());
            $this->enlace->save();
        } catch (QueryException $e) {
            return $this->respondError($e->errorInfo);
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        return $this->respond($this->enlace);
    }

    public function actualizar(GuardarEnlace $request, Enlace $enlace)
    {
        try {
            $enlace->fill($request->validated());
            $enlace->save();
        } catch (QueryException $e) {
            return $this->respondError($e->errorInfo);
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        return $this->respondNoContent();
    }

    public function mostrar(Enlace $enlace)
    {
        return $this->respond($enlace);
    }

    public function eliminar(Enlace $enlace)
    {
        try {
            $enlace->delete();
        } catch (QueryException $e) {
            return $this->respond($e->errorInfo);
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        return $this->respondSuccess();
    }
}
