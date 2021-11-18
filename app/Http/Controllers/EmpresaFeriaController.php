<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarEmpresaFeria;
use App\Http\Requests\CrearEmpresaFeria;
use App\Models\EmpresaFeria;
use App\Services\FileService;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
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
            $fileExt = $file->getClientOriginalExtension();
            $path = $file->storeAs('feria', uniqid('logo_').'.'.$fileExt, 'images');
            $this->empresa->url_logo = $path;
            $this->empresa->fill($request->validated());
            $this->empresa->save();
        } catch (QueryException $e) {
            return $this->respondError($e->getMessage());
        } catch (Exception $e) {
            return $this->respondError($e->getMessage());
        }
        return $this->respondCreated($this->empresa);
    }

    public function mostrar(EmpresaFeria $empresa)
    {
        return $this->respond($empresa);
    }

    public function actualizar(ActualizarEmpresaFeria $request, EmpresaFeria $empresa)
    {
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileExt = $file->getClientOriginalExtension();
            $nuevoLogo = $file->storeAs('feria', uniqid('logo_').'.'.$fileExt, 'images');
            $antiguoLogo = $empresa->server_path_logo;
            $empresa->url_logo = $nuevoLogo;
        }
        try {
            $empresa->fill($request->validated());
            if ($empresa->isDirty()) {
                $empresa->save();
            }
            if (isset($nuevoLogo) && Storage::disk('images')->exists($antiguoLogo)) {
                Storage::disk('images')->delete($antiguoLogo);
            }
        } catch (QueryException $e) {
            if (isset($nuevoLogo)) {
                Storage::disk('images')->delete($nuevoLogo);
            }
            return $this->respondError($e->getMessage());
        } catch (Exception $e) {
            return $this->respondError($e->getMessage());
        }
        return $this->respondNoContent();
    }

    public function eliminar(EmpresaFeria $empresa)
    {
        try {
            $empresa->delete();
            $this->fileService->eliminarArchivo($empresa->server_path_logo, 'images');
        } catch (QueryException $e) {
            return $this->respondError($e->getMessage());
        } catch (FileNotFoundException $e) {
            return $this->respondError($e->getMessage());
        }
    }

    public function totalEmpresas()
    {
        return $this->respond($this->empresa->all()->count());
    }
}
