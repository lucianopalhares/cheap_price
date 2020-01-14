<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App;

class HomeController extends Controller
{
    public $category;
    public $product;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->category = App::make('App\Category');
      $this->product = App::make('App\Product');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = $this->product::whereHas('prices', function($q){
            $q->whereDate('date_end', '>=', \Carbon\Carbon::today()->toDateString())->orderBy('price');
        })->get();
        
        return view('site.index',compact('products'));
    }
}
