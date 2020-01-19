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
    
    public function __construct(){
      
      $this->middleware('company', ['only' => ['create','edit']]);
      
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
        return view('admin.price.index',compact('items'));
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
        return view('admin.price.form',compact('products','companies'));
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
              'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
              'date_start' => 'nullable|date_format:d/m/Y',
              'date_end' => 'nullable|date_format:d/m/Y',
              'product_id' => 'required'
          ];            
          
        }else{
          
          $rules = [
              'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
              'date_start' => 'nullable|date_format:d/m/Y',
              'date_end' => 'nullable|date_format:d/m/Y',
              'product_id' => 'required'
          ];          
        }

        $this->validate($request, $rules);

        $product = $this->product->findOrFail($request->product_id);
        $slug = str_slug($product->name().'-'.$request->price.'-'.$request->date_start.'ate'.$request->date_end);

        try {

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
            
            $response = trans('app.price').' ';
            
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
            
        } catch (\Exception $e) {//errors exceptions
          
            $response = null;
            
            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }              
            
            if (request()->wantsJson()) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withInput($request->toArray())->withErrors($response);
            }  
          
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {       
        try {
          
            $item = $this->model->findOrFail($id);
            $products = $this->product::all();
            $companies = $this->company::all();
            return view('admin.price.form',compact('item','products','companies'));
            
        } catch (\Exception $e) {//errors exceptions
          
            $response = null;
            
            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              default: $response = get_class($e);
            }              
            
            if (request()->wantsJson()) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return redirect('/admin/price')->withErrors($response);
            }  
          
        }   


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
        try {
          
            $model = $this->model->findOrFail($id);
            
            $deleted = $this->model->destroy($id); 
            
            $response = trans('app.price').' '.trans('app.deleted_success');
                                                
            if (request()->wantsJson()) {
              return response()->json(['status'=>true,'msg'=>$response]);
            }else{
              return back()->with('success', $response);
            }    
            
        } catch (\Exception $e) {//errors exceptions
          
            $response = null;
            
            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              default: $response = get_class($e);
            }              
            
            if (request()->wantsJson()) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return redirect('/admin/price')->withErrors($response);
            }  
          
        }  
    }
}
