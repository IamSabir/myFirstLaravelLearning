<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
  public function posts()
    {
        return $this->hasManyThrough('App\Models\PostModel', 'App\Models\User', 'country_id', 'id');    
    }

}
