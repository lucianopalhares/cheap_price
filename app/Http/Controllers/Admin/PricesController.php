<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;
use \Carbon\Carbon;
use Auth;

class PricesController extends Controller
{
    protected $model;
    protected $company;
    protected $product;
    protected $title;
    protected $path_view;
    
    public function __construct(){
      
      $this->middleware('company', ['only' => ['create','edit']]);

      $this->title = trans('app.price');
      $this->path_view = 'admin.price';      
      $this->company = App::make('App\Company');
      $this->product = App::make('App\Product');
      $this->model = App::make('App\Price');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->model::paginate(10);
        return view($this->path_view.'.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $products = $this->product::all();
        $companies = $this->company::all();
        return view($this->path_view.'.form',compact('products','companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $update = false;
        
        if(isset($request->id)){
          $update = true;
        }
        
        if($update){
          
          $rules = [
              'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
              'date_start' => 'nullable|date_format:d/m/Y',
              'date_end' => 'nullable|date_format:d/m/Y',
              'product_id' => 'required'
          ];            
          
        }else{
          
          $rules = [
              'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
              'date_start' => 'nullable|date_format:d/m/Y',
              'date_end' => 'nullable|date_format:d/m/Y',
              'product_id' => 'required'
          ];          
        }
        
        $this->validate($request, $rules);

        $product = $this->product->findOrFail($request->product_id);
        $slug = str_slug($product->name().'-'.$request->price.'-'.$request->date_start.'ate'.$request->date_end);

        if($update){

            $model = $this->model->findOrFail($request->id);
                
        }else{
            $model = new App\Price;
        }
        $model->price = $request->price;
        $model->date_start = Carbon::createFromFormat('d/m/Y', $request->date_start)->format('Y-m-d');
        $model->date_end = Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d');
        $model->slug = $slug;
        $model->product_id = $request->product_id;  
        $model->company_id = Auth::user()->company->id;
        $model->status = $request->status;  
                        
        $save = $model->save();
            
        $response = $this->title.' ';
            
        if($update){
          $response .= trans('app.updated_success');
        }else{
          $response .= trans('app.created_success');
        }
            
        if (request()->wantsJson()) {
          return response()->json(['status'=>true,'msg'=>$response]);
        }else{
          return back()->with('success', $response);
        }               
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $show = true;
        $item = $this->model->findOrFail($id);
        $products = $this->product::all();
        $companies = $this->company::all();
        return view($this->path_view.'.form',compact('item','products','companies','show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {                 
        $item = $this->model->findOrFail($id);
        $products = $this->product::all();
        $companies = $this->company::all();
        return view($this->path_view.'.form',compact('item','products','companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {          
        $model = $this->model->findOrFail($id);
            
        $deleted = $this->model->destroy($id); 
            
        $response = $this->title.' '.trans('app.deleted_success');
                                                
        if (request()->wantsJson()) {
          return response()->json(['status'=>true,'msg'=>$response]);
        }else{
          return back()->with('success', $response);
        }    
    }
}
