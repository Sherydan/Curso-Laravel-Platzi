<?php

namespace App;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Message extends Model
{
    use Searchable;
    
    public function user(){
        # un mensaje pertenece a un usuario
        return $this->belongsTo(User::class);
    }

    # intercepto el pedido a la propiedad image
    # es una funcion magica, por lo tanto con darle el nombre "getImageAttribute" funciona

    public function getImageAttribute($image){
        if (!$image || starts_with($image, 'http')) {
            return $image;
        }
        return Storage::url($image);
    }

    public function toSearchableArray(){
        # decirle a algola que cargue el mensaje con el usuario ya precargado
        # esto me permite tambien buscar los usuarios dentro de la query
        $this->load('user');
        return $this->toArray();
    }

    public function responses(){
        return $this->hasMany(Response::class)->latest();
    }
    
    # eliminar error de massasignmemt
    protected $guarded = [];
}
