<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    public $fillable = ['nombre'];

    public function setNombreAttribute(string $value)
    {
        $this->attributes['nombre'] = ucfirst($value);
    }

    public function empresas()
    {
        return $this->hasMany(Empresa::class);
    }
}
