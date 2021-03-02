<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{

    protected $table = 'posts';
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // public function userroles(){
    //     return $this->belongsToMany('App\Models\Role', 'role_user', 'user_id', 'role_id');
    // }

    public function photos()
    {
        return $this->morphMany('App\Models\Photo', 'imageable');
    }

    public function tags()
    {
        return $this->morphToMany('App\Models\Tag', 'tagable');
    }
}
