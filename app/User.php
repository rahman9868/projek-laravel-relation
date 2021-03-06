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
        'name', 'email', 'password','role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
  

    /**
     * Method One To One Profile
     */
    public function profile(){
        return $this->hasOne(profile::class);
    }

    /**
     * Method One to Many User -> Post
     */
    public function posts(){
        return $this->hasMany(Post::class);
    }
}
