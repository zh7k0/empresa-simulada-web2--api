<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarCategoria;
use App\Http\Requests\CrearCategoria;
use App\Models\Categoria;
use Illuminate\Database\QueryException;

class CategoriaController extends APIController
{
    private Categoria $categoria;

    public function __construct(Categoria $categoria)
    {
        $this->categoria = $categoria;
    }

    public function obtenerCategorias()
    {
        $categorias = $this->categoria->all();
        return $this->respond($categorias);
    }

    public function crear(CrearCategoria $request)
    {
        try {
            $this->categoria->fill($request->validated());
            $this->categoria->save();
        } catch (QueryException $e) {
            return $this->respondError($e->getMessage());
        } catch (\Throwable $th) {
            return $this->respondError($e->getMessage());
        }
        return $this->respondCreated($this->categoria);
    }

    public function mostrar(Categoria $categoria)
    {
        return $this->respond($categoria);
    }

    public function actualizar(ActualizarCategoria $request, Categoria $categoria)
    {
        try {
            $categoria->fill($request->validated());
            $categoria->save();
        } catch (QueryException $e) {
            return $this->respond($e->getMessage());
        } catch (\Throwable $th) {
            return $this->respondError($e->getMessage());
        }
        return $this->respondNoContent();
    }

    public function eliminar(Categoria $categoria)
    {
        $categoria->loadCount('empresas');
        if ($categoria->empresas_count > 0) {
            $mensaje = 'No se puede eliminar categoría porque tiene empresas asociadas';
            return $this->respondError($mensaje, 422);
        }
        try {
            $categoria->delete();
        } catch (QueryException $e) {
            return $this->respondError($e->getMessage());
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        return $this->respondSuccess();
    }
}
