<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_name', 'desc',
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function scopeSelection($query)
    {
        return $query->select('id', 'role_name', 'desc');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'role_id')->select('id', 'name', 'age', 'email');
    }
}
