<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = ['razon_social', 'url_logo', 'url_web', 'categoria_id'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function getUrlLogoAttribute()
    {
        $urlLogo = $this->attributes['url_logo'];
        $fullUrl = Storage::disk('images')->url($urlLogo);
        return $fullUrl;
    }

    public function getServerPathLogoAttribute()
    {
        return $this->attributes['url_logo'];
    }
}
