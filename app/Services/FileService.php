<?php

namespace App\Services;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function eliminarLogoEmpresaWebshop(string $rutaArchivo)
    {
        $this->eliminarArchivo($rutaArchivo, 'images');
    }

    public function eliminarLogoEmpresaFeria(string $rutaArchivo)
    {
        $this->eliminarArchivo($rutaArchivo, 'images');
    }

    /**
     * @throws FileNotFoundException
     */
    public function eliminarArchivo(string $rutaRelativa, string $disco = 'public')
    {
        if (! Storage::disk($disco)->exists($rutaRelativa)) {
            throw new FileNotFoundException('Archivo no existe en disco '.$disco);
        }
        Storage::disk($disco)->delete($rutaRelativa);
    }

    /**
     * @throws Exception
     */
    public function guardarLogoEmpresaFeria(UploadedFile $file)
    {
        return $this->guardarLogoPublico($file, 'feria');
    }

    /**
     * @throws Exception
     */
    public function guardarLogoEmpresaWebshop(UploadedFile $file)
    {
        return $this->guardarLogoPublico($file, 'webshop');
    }

    public function guardarLogoPublico(UploadedFile $file, string $destino = '')
    {
        $prefijoArchivo = 'logo_';
        $nombreArchivo = uniqid($prefijoArchivo, true);
        $rutaLogo = $this->guardarImagenPublica($file, $destino, $nombreArchivo);
        return $rutaLogo;
    }

    public function guardarImagenPublica(UploadedFile $file, string $destino, string $nombre = '')
    {
        $rutaImagen = $this->guardarArchivo($file, $destino, $nombre, 'images');
        return $rutaImagen;
    }

    public function guardarArchivo(UploadedFile $file, string $destino = '', string $nombre = '', $disco = 'local')
    {
        $fileExt = $file->extension();
        $rutaArchivoGuardado = $file->storeAs($destino, $this->crearNombreArchivo($nombre, $fileExt), $disco);
        if ($rutaArchivoGuardado === false) {
            throw new Exception('No se pudo guardar archivo');
        }
        return $rutaArchivoGuardado;
    }

    private function crearNombreArchivo(string $nombre = '', string $extension = '')
    {
        $nombreArchivo = $nombre.'.'.$extension;
        if (empty($nombre)) {
            $nombreArchivo = $this->crearNombrePorDefecto($extension).'.'.$extension;
        }
        return $nombreArchivo;
    }

    private function crearNombrePorDefecto(string $extension)
    {
        $nombrePorDefecto = uniqid('archivo_', true).'.'.$extension;
        return $nombrePorDefecto;
    }
}
