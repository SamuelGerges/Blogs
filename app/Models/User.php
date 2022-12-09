<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

//use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'age',
        'email',
        'password',
    ];

    protected $hidden = [
        'password', 'role_id',
        'remember_token',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($password)
    {
        if (!empty($password))
            $this->attributes['password'] = bcrypt($password);
    }

    public function scopeSelection($query)
    {
        return $query->select('id', 'name', 'age', 'email', 'role_id');
    }

    public function post()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id')->select('id', 'role_name');
    }

}
