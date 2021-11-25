<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_evento', 'fecha_realizacion', 'categorias', 'esta_habilitado', 'link_evento'
    ];

    protected $casts = [
        'esta_habilitado' => 'boolean',
        'categorias' => 'array',
    ];

    public function hayFeria()
    {
        return $this->where('tipo_evento', 'feria')
            ->get()
            ->count();
    }

    public function feria()
    {
        return $this->where('tipo_evento', 'feria')
                ->first();
    }

    public function setFechaRealizacionAttribute($value)
    {
        $fecha = Carbon::createFromFormat('Y-m-d\TH:i:s.v\Z', $value);
        $this->attributes['fecha_realizacion'] = $fecha;
    }

    public function getFechaRealizacionAttribute()
    {
        $fecha = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['fecha_realizacion']);
        return $fecha->format('Y-m-d\TH:i:s.v\Z');
    }
}
