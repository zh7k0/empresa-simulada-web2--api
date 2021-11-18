<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarFeria;
use App\Http\Requests\CrearFeria;
use App\Models\Evento;
use Exception;
use Illuminate\Database\QueryException;

class EventoController extends APIController
{

    private Evento $evento;

    public function __construct(Evento $evento)
    {
        $this->evento = $evento;
    }

    public function obtenerFeria()
    {
        $feria = $this->evento->feria();
        if (is_null($feria)) {
            return $this->respondNotFound();
        }
        return $this->respond($feria);
    }

    public function guardarFeria(CrearFeria $request)
    {
        if ($this->evento->hayFeria()) {
            return $this->respondError('Ya hay una feria creada', 405);
        }
        try {
            $this->evento->fill($request->validated());
            $this->evento->save();
        } catch (QueryException $e) {
            return $this->respondError($e->getMessage());
        } catch (Exception $e) {
            return $this->respondError(($e->getMessage()));
        }
        return $this->respondCreated($this->evento);
    }

    public function actualizarFeria(ActualizarFeria $request, Evento $feria)
    {
        $feria->fill($request->validated());
        if ($feria->isDirty()) {
            $feria->save();
        }
        return $this->respondNoContent();
    }
}
