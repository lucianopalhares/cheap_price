<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $guarded = [];
    
    public function product(){
      return $this->belongsTo('App\Product','product_id');
    } 
    public function company(){
      return $this->belongsTo('App\Company','company_id');
    } 
}
