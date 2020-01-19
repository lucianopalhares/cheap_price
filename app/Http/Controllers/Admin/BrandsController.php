<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;

class BrandsController extends Controller
{
    protected $model;
    protected $title;
    
    public function __construct(){
      $this->title = trans('app.brand');
      $this->model = App::make('App\Brand');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->model::paginate(10);
        return view('admin.brand.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.form');
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
              'name' =>  ['required','max:100',Rule::unique('brands')->ignore($request->id)],
          ];            
          
        }else{
          
          $rules = [
              'name' =>  'required|unique:brands|max:100',
          ];          
        }

        $this->validate($request, $rules);

        $slug = str_slug($request->name);

        if($update){

            $model = $this->model->findOrFail($request->id);
                
        }else{
            $model = new App\Brand;
        }
        $model->name = $request->name;
        $model->slug = $slug;  
            
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
        $item = $this->model->findOrFail($id);
        $show = true;
        return view('admin.brand.form',compact('item','show'));    

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
