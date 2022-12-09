<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory,SoftDeletes;

    protected $table ='posts';
    protected $fillable = [
        'id','name','content',
        'status',
        'user_id',
    ];
    protected $dates = [ 'deleted_at' ];

    public function scopeSelection($query)
    {

        return $query->select('id','name','content','user_id') ;
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->select('id','name');
    }


}
