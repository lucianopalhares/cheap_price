<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;

class SubCategoriesController extends Controller
{
    protected $model;
    protected $category;
    protected $title;
    protected $path_view;
    
    public function __construct(){
      $this->title = trans('app.sub_category');
      $this->path_view = 'admin.sub_category'; 
      $this->category = App::make('App\Category');
      $this->model = App::make('App\SubCategory');
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
        $categories = $this->category::all();
        return view($this->path_view.'.form',compact('categories'));
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
              'category_id' => 'required',
              'name' =>  ['required','max:100',Rule::unique('sub_categories')->ignore($request->id)],
          ];            
          
        }else{
          
          $rules = [
              'category_id' => 'required',
              'name' =>  'required|unique:sub_categories|max:100',
          ];          
        }

        $this->validate($request, $rules);

        $slug = str_slug($request->name);

            if($update){

                $model = $this->model->findOrFail($request->id);
                
            }else{
                $model = new App\SubCategory;
            }
            $model->name = $request->name;
            $model->slug = $slug;
            $model->category_id = $request->category_id;   
            
            $save = $model->save();
            
            $response = trans('app.sub_category').' ';
            
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
        $categories = $this->category::all();
        return view('admin.sub_category.form',compact('categories','item','show'));  
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
        $categories = $this->category::all();
        return view('admin.sub_category.form',compact('categories','item'));  
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
