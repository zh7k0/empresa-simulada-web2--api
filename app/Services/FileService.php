<?php

namespace App\Services;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

class FileService
{

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
}
