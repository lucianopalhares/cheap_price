<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $guarded = [];
    
    public function categories(){
      return $this->hasMany('App\Category','type_id');
    }
    public function products(){
      return $this->hasMany('App\Product','type_id');
    }
}
