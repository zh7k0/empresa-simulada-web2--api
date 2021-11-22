<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarEmpresa;
use App\Http\Requests\CrearEmpresa;
use App\Models\Empresa;
use App\Services\FileService;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class EmpresaController extends APIController
{
    private Empresa $empresa;
    private FileService $fileService;

    public function __construct(Empresa $empresa, FileService $fileService)
    {
        $this->empresa = $empresa;
        $this->fileService = $fileService;
    }

    public function obtenerEmpresas()
    {
        $empresas = $this->empresa->all();
        return $this->respond($empresas);
    }

    public function crear(CrearEmpresa $request)
    {
        try {
            $file = $request->file('logo');
            $path = $this->fileService->guardarLogoEmpresaWebshop($file);
            $this->empresa->url_logo = $path;
            $this->empresa->fill($request->validated());
            $this->empresa->save();
        } catch (QueryException $e) {
            return $this->respondError($e->errorInfo);
        } catch (FileNotFoundException $e) {
            return $this->respondError($e->getMessage());
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        return $this->respondCreated($this->empresa);
    }

    public function mostrar(Empresa $empresa)
    {
        return $this->respond($empresa);
    }

    public function actualizar(ActualizarEmpresa $request, Empresa $empresa)
    {
        try {
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $rutaNuevoLogo = $this->fileService->guardarLogoEmpresaWebshop($file);
                $rutaAntiguoLogo = $empresa->server_path_logo;
                $empresa->url_logo = $rutaNuevoLogo;
            }
            $empresa->fill($request->validated());
            $empresa->save();
            $this->fileService->eliminarLogoEmpresaWebshop($rutaAntiguoLogo);
        } catch (QueryException $e) {
            if (isset($rutaNuevoLogo)) {
                $this->fileService->eliminarLogoEmpresaWebshop($rutaNuevoLogo);
            }
            if ($e->errorInfo[1] === 1062) {
                $mensaje = 'Empresa ya existe';
                $errores = ['razon_social' => [$mensaje]];
                return $this->respondError($errores, 422);
            }
            return $this->respondError($e->errorInfo);
        } catch (FileNotFoundException $e) {
            return $this->respondError($e->getMessage());
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        return $this->respondNoContent();
    }

    public function eliminar(Empresa $empresa)
    {
        try {
            $empresa->delete();
            $this->fileService->eliminarLogoEmpresaWebshop($empresa->server_path_logo);
        } catch (QueryException $e) {
            return $this->respondError($e->errorInfo);
        } catch (ModelNotFoundException $e) {
            return $this->respondError($e->getMessage());
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        return $this->respondSuccess();
    }
}
