<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyType extends Model
{
    protected $guarded = [];
    
    public function companies(){
      return $this->hasMany('App\Company','company_type_id');
    } 
}
