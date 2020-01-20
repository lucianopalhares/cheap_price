<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductsController extends Controller
{
    protected $model;
    protected $type;
    protected $category;
    protected $sub_category;
    protected $brand;
    protected $measure;
    protected $title;
    protected $path_view;
    
    public function __construct(){
      $this->title = trans('app.product');
      $this->path_view = 'admin.product'; 
      $this->model = App::make('App\Product');
      $this->type = App::make('App\Type');
      $this->category = App::make('App\Category');
      $this->sub_category = App::make('App\SubCategory');
      $this->brand = App::make('App\Brand');
      $this->measure = App::make('App\Measure');
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
        $categories = $this->category::all();
        $sub_categories = $this->sub_category::all();
        $brands = $this->brand::all();
        $measures = $this->measure::all();
        
        return view($this->path_view.'.form',compact('sub_categories','brands','measures'));
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
              'sub_category_id' =>  'required',
              'measure_number' =>  'required',
              'measure_id' =>  'required',
              'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1500',
          ];            
          
        }else{
          
          $rules = [
              'sub_category_id' =>  'required',
              'measure_number' =>  'required',
              'measure_id' =>  'required',
              'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1500',
          ];          
        }

        $this->validate($request, $rules);
        
            if($update){

                $model = $this->model->findOrFail($request->id);
                $image_before_update = $model->image;
                
            }else{
                $model = new App\Product;
            }
            
            $sub_category = $this->sub_category->findOrFail($request->sub_category_id);
            
            $model->type_id = $sub_category->category->type_id;
            $model->category_id = $sub_category->category_id;
            $model->sub_category_id = $request->sub_category_id;
            if(strlen($request->brand_id)>0&&$request->brand_id>0){
              $model->brand_id = $request->brand_id;
            }
            if(strlen($request->model)>0){
              $model->model = $request->model;
            }
            $model->measure_number = $request->measure_number;
            $model->measure_id = $request->measure_id;
            if(strlen($request->description)>0){
              $model->description = $request->description;
            }
            if(strlen($request->image)>0){
              if($update){
                $model->image = $request->image;
              }
            }        
            $model->save();
            
            $response = $this->title.' ';
            
            if($update){
              $response .= trans('app.updated_success');
            }else{
              $response .= trans('app.created_success');
            }
                      
            
            if ($request->hasFile('image')){
              
                $image = $request->file('image');

                $file_base_name = str_replace('.'.$image->getClientOriginalExtension(), '', $image->getClientOriginalName());

                $resized = Image::make($image)->resize(640, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->stream();
                $resized_thumb = Image::make($image)->resize(320, 213)->stream();

                $image_name = strtolower(time().str_random(5).'-'.str_slug($file_base_name)).'.' . $image->getClientOriginalExtension();

                $imageFileName = 'images/products/'.$image_name;
                $imageThumbName = 'images/products/thumbs/'.$image_name;

                try{
                  
                   //return $imageThumbName;
                    
                    $storage = Storage::disk('public');
                    //Upload original image
                    $is_uploaded = $storage->put($imageFileName, $resized->__toString(), 'public');

                    if ($is_uploaded) {
                        //Save image name into db
                        $update_model = $this->model->findOrFail($model->id);
                        $update_model->image = $image_name;
                        $update_model->save();
                        //upload thumb image
                        $storage->put($imageThumbName, $resized_thumb->__toString(), 'public');
                        $img_url = asset('images/products/thumbs/'.$image_name);
                        //return ['success' => 1, 'img_url' => $img_url];
                        if($update){
                          if ($storage->has('images/products/'.$image_before_update)){
                              $storage->delete('images/products/'.$image_before_update);
                          }
                          if ($storage->has('images/products/thumbs/'.$image_before_update)){
                              $storage->delete('images/products/thumbs/'.$image_before_update);
                          }
                        }
                    } else {
                        $response .= ' '.trans('app.image_not_uploaded');
                    }
                } catch (\Exception $e){
                    $response .= ' (Error: '.$e->getMessage().')';
                }

            }else{
              if($update){
                if(strlen($image_before_update)>0){
                  
                  $storage = Storage::disk('public');
                  if (!$storage->has('images/products/thumbs/'.$image_before_update)){
                      $response .= ' '.trans('app.image_not_uploaded');
                  }                  
                }else{
                  $response .= ' '.trans('app.image_not_uploaded');
                }
              }else{
                $response .= ' '.trans('app.image_not_uploaded');
              }
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
        $categories = $this->category::all();
        $sub_categories = $this->sub_category::all();
        $brands = $this->brand::all();
        $measures = $this->measure::all();
        
        return view($this->path_view.'.form',compact('item','sub_categories','brands','measures','show'));
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
        $categories = $this->category::all();
        $sub_categories = $this->sub_category::all();
        $brands = $this->brand::all();
        $measures = $this->measure::all();
        
        return view($this->path_view.'.form',compact('item','sub_categories','brands','measures'));
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

            $storage = Storage::disk('public');
            if ($storage->has('images/products/'.$model->image)){
                $storage->delete('images/products/'.$model->image);
            }
            if ($storage->has('images/products/thumbs/'.$model->image)){
                $storage->delete('images/products/thumbs/'.$model->image);
            }
                    
            $deleted = $this->model->destroy($id); 
            
            $response = $this->title.' '.trans('app.deleted_success');
                                                
            if (request()->wantsJson()) {
              return response()->json(['status'=>true,'msg'=>$response]);
            }else{
              return back()->with('success', $response);
            }    
            
   
    }

}
