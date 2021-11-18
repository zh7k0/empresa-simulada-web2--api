<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class EmpresaFeria extends Model
{
    use HasFactory;

    protected $table = 'empresas_feria';

    protected $fillable = [
        'razon_social', 'descripcion', 'url_stream',
        'url_logo', 'instagram', 'youtube', 'facebook',
        'categoria'
    ];

    public function getYoutubeAttribute()
    {
        if (is_null($this->attributes['youtube'])) {
            return '';
        }
        return $this->attributes['youtube'];
    }

    public function getInstagramAttribute()
    {
        $instagram = $this->attributes['instagram'];
        if (is_null($instagram)) {
            return '';
        }
        return $instagram;
    }

    public function getFacebookAttribute()
    {
        $facebook = $this->attributes['facebook'];
        if (is_null($facebook)) {
            return '';
        }
        return $facebook;
    }

    public function getUrlLogoAttribute()
    {
        $url_logo = $this->attributes['url_logo'];
        $path = Storage::disk('images')->url($url_logo);
        return $path;
    }

    public function getServerPathLogoAttribute()
    {
        return $this->attributes['url_logo'];
    }
}
