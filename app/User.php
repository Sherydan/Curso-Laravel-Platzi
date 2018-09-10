<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username', 'avatar', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function messages(){
        return $this->hasMany(Message::class)->orderBy('created_at', 'desc');
    }

    public function follows(){

        # busca los otros usuarios, donde yo soy el user_id y los otros son los followed
        # yo los sigo a ellos
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'followed_id');
    }

    public function followers(){
        # yo soy el que es seguido, dime quienes son los que me siguen
        return $this->belongsToMany(User::class, 'followers', 'followed_id', 'user_id');
    }

    # añado la funcion is following al modelo para poder llamarla en la vista de la forma (auth()->user()->isFollowing($user))
    public function isFollowing(User $user){
        return $this->follows->contains($user);
    }

    public function socialProfiles(){
        return $this->hasMany(SocialProfile::class);
    }
}
