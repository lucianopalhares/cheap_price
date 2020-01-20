<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;

class CategoriesController extends Controller
{
    protected $model;
    protected $type;
    protected $title;
    protected $path_view;
    
    public function __construct(){
      $this->title = trans('app.category');
      $this->path_view = 'admin.category';
      $this->type = App::make('App\Type');
      $this->model = App::make('App\Category');
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
        $types = $this->type::all();
        return view($this->path_view.'.form',compact('types'));
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
              'type_id' => 'required',
              'name' =>  ['required','max:100',Rule::unique('categories')->ignore($request->id)],
          ];            
          
        }else{
          
          $rules = [
              'type_id' => 'required',
              'name' =>  'required|unique:categories|max:100',
          ];          
        }

        $this->validate($request, $rules);

        $slug = str_slug($request->name);

        if($update){

          $model = $this->model->findOrFail($request->id);
                
        }else{
          $model = new App\Category;
        }
        $model->name = $request->name;
        $model->slug = $slug;
        $model->type_id = $request->type_id;   
            
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
        $types = $this->type::all();
        return view($this->path_view.'.form',compact('types','item','show')); 
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
        $types = $this->type::all();
        return view($this->path_view.'.form',compact('types','item'));  
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
