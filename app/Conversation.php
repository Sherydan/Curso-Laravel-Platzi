<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function privateMessages(){
        return $this->hasMany(PrivateMessage::class)->orderBy('created_at', 'desc');
    }

    #function para encontrar o crear una conversacion entre usuarios
    public static function between(User $user, User $other){

        # encontrar la conversacion que tiene el id de un usuario con el id del otro usuario
        $query = Conversation::whereHas('users', function($query) use ($user){
            $query->where('user_id', $user->id);
        })->whereHas('users', function ($query) use ($other){
            $query->where('user_id', $other->id);
        });

        # creo la conversation (si la creo, se crea vacia, por eso debo syncronizar ambos users)
        $conversation = $query->firstOrCreate([]);

        # garantizo que ambos usuarios esten en ella
        $conversation->users()->sync([
            $user->id, $other->id
        ]);

        return $conversation;
    }
}
