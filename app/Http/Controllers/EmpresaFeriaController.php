<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarEmpresaFeria;
use App\Http\Requests\CrearEmpresaFeria;
use App\Models\EmpresaFeria;
use App\Services\FileService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class EmpresaFeriaController extends APIController
{
    private EmpresaFeria $empresa;
    private FileService $fileService;

    public function __construct(EmpresaFeria $empresa, FileService $fileService)
    {
        $this->empresa = $empresa;
        $this->fileService = $fileService;
    }

    public function listarEmpresas()
    {
        return $this->respond($this->empresa->all());
    }

    public function crear(CrearEmpresaFeria $request)
    {
        try {
            $file = $request->file('logo');
            $path = $this->fileService->guardarLogoEmpresaFeria($file);
            $this->empresa->url_logo = $path;
            $this->empresa->fill($request->validated());
            $this->empresa->save();
        } catch (QueryException $e) {
            return $this->respondError($e->errorInfo);
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        return $this->respondCreated($this->empresa);
    }

    public function mostrar(EmpresaFeria $empresa)
    {
        return $this->respond($empresa);
    }

    public function actualizar(ActualizarEmpresaFeria $request, EmpresaFeria $empresa)
    {
        try {
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $nuevoLogo = $this->fileService->guardarLogoEmpresaFeria($file);
                $antiguoLogo = $empresa->server_path_logo;
                $empresa->url_logo = $nuevoLogo;
            }
            $empresa->fill($request->validated());
            $empresa->save();
            if (isset($nuevoLogo) && Storage::disk('images')->exists($antiguoLogo)) {
                $this->fileService->eliminarLogoEmpresaFeria($antiguoLogo);
            }
        } catch (QueryException $e) {
            if (isset($nuevoLogo)) {
                $this->fileService->eliminarLogoEmpresaFeria($nuevoLogo);
            }
            if ($e->errorInfo[1] === 1062) {
                $mensaje = 'Empresa ya existe';
                $errores = ['razon_social' => [$mensaje]];
                return $this->respondError($errores, 422);
            }
            return $this->respondError($e->getMessage());
        } catch (FileNotFoundException $e) {
            return $this->respondError($e->getMessage());
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        return $this->respondNoContent();
    }

    public function eliminar(EmpresaFeria $empresa)
    {
        try {
            $empresa->delete();
            $this->fileService->eliminarLogoEmpresaFeria($empresa->server_path_logo);
        } catch (QueryException $e) {
            return $this->respondError($e->getMessage());
        } catch (FileNotFoundException $e) {
            return $this->respondError($e->getMessage());
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        return $this->respondSuccess();
    }

    public function totalEmpresas()
    {
        return $this->respond($this->empresa->all()->count());
    }
}
