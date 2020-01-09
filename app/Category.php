<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    
    public function type(){
      return $this->belongsTo('App\Type','type_id');
    }
    public function subcategories(){
      return $this->hasMany('App\SubCategory','category_id');
    }  
    public function products(){
      return $this->hasMany('App\Product','category_id');
    }    
}
