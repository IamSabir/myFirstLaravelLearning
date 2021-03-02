<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function posts(){
        return $this->morphedByMany('App\Models\PostModel', 'tagable');
    }
    public function video(){
        return $this->morphedByMany('App\Models\Video', 'tagable');
    }
}
