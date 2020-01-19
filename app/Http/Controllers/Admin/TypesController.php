<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;

class TypesController extends Controller
{
    protected $model;
    
    public function __construct(){
      $this->model = App::make('App\Type');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->model::paginate(10);
        return view('admin.type.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.type.form');
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
              'name' =>  ['required','max:100',Rule::unique('types')->ignore($request->id)],
          ];            
          
        }else{
          
          $rules = [
              'name' =>  'required|unique:types|max:100',
          ];          
        }

        $this->validate($request, $rules);

        $slug = str_slug($request->name);

        try {

            if($update){

                $model = $this->model->findOrFail($request->id);
                
            }else{
                $model = new App\Type;
            }
            $model->name = $request->name;
            $model->slug = $slug;  
            
            $save = $model->save();
            
            $response = trans('app.type').' ';
            
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
            return view('admin.type.form',compact('item'));  
            
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
              return redirect('/admin/type')->withErrors($response);
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
            
            $response = trans('app.type').' '.trans('app.deleted_success');
                                                
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
              return redirect('/admin/type')->withErrors($response);
            }  
          
        }  
    }
}
