<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use \App;

class MeasuresController extends Controller
{
    protected $model;
    protected $title;
    protected $path_view;
    
    public function __construct(){
      $this->title = trans('app.measure');
      $this->path_view = 'admin.measure';
      $this->model = App::make('App\Measure');
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
        return view($this->path_view.'.form');
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
              'name' =>  ['required','max:100',Rule::unique('measures')->ignore($request->id)],
              'abbrev' =>  ['required','max:50',Rule::unique('measures')->ignore($request->id)],
          ];            
          
        }else{
          
          $rules = [
              'name' =>  'required|unique:measures|max:100',
              'abbrev' =>  'required|unique:measures|max:50',
          ];          
        }

        $this->validate($request, $rules);

        $slug = str_slug($request->name);

        if($update){

            $model = $this->model->findOrFail($request->id);
                
        }else{
            $model = new App\Measure;
        }
        $model->name = $request->name;
        $model->abbrev = $request->abbrev;
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
        $show = true;
        $item = $this->model->findOrFail($id);
        return view($this->path_view.'.form',compact('item','show')); 
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
        return view($this->path_view.'.form',compact('item'));   
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
