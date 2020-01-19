<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];
    
    public function prices(){
      return $this->hasMany('App\Price','company_id');
    }  
    public function companyType(){
      return $this->belongsTo('App\CompanyType','company_type_id');
    } 
    public function user(){
      return $this->belongsTo('App\User','user_id');
    } 
}
