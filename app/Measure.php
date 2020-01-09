<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Measure extends Model
{
    protected $guarded = [];
    
    public function products(){
      return $this->hasMany('App\Product','measure_id');
    } 
}
