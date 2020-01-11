<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    
    public function type(){
      return $this->belongsTo('App\Type','type_id');
    } 
    public function category(){
      return $this->belongsTo('App\Category','category_id');
    }     
    public function subCategory(){
      return $this->belongsTo('App\SubCategory','sub_category_id');
    }  
    public function brand(){
      return $this->belongsTo('App\Brand','brand_id');
    } 
    public function measure(){
      return $this->belongsTo('App\Measure','measure_id');
    }                 
    public function prices(){
      return $this->hasMany('App\Price','product_id');
    } 
}
