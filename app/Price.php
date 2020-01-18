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
    public function date_start_format(){
      return isset($this->date_start)&&strlen($this->date_start)>0?\Carbon::createFromFormat(config('app.date_format'), $this->date_start)->format('Y-m-d'):null;
    }
    public function date_end_format(){
      return isset($this->date_start)&&strlen($this->date_end)>0?trans('app.until').' '.\Carbon::createFromFormat(config('app.date_format'), $this->date_start)->format('Y-m-d'):null;
    }
}
