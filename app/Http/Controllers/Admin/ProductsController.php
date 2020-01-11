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
    
    public function __construct(){
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
        return view('admin.product.index',compact('items'));
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
        
        return view('admin.product.form',compact('sub_categories','brands','measures'));
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
        
        

        try {

            if($update){

                $model = $this->model->findOrFail($request->id);
                
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
            
            $response = trans('app.product').' ';
            
            if($update){
              $response .= trans('app.updated_success');
            }else{
              $response .= trans('app.created_success');
            }
                      
            
            if ($request->hasFile('image')){
              
                $image = $request->file('image');
                $valid_extensions = ['jpg','jpeg','png'];

                if ( ! in_array(strtolower($image->getClientOriginalExtension()), $valid_extensions) ){
                  
                    return ['success' => 0, 'msg' => implode(',', $valid_extensions).' '.trans('app.valid_extension_msg')];
                }

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
                    } else {
                        return ['success' => 0];
                    }
                } catch (\Exception $e){
                    $response .= ' (Error: '.$e->getMessage().')';
                }

            }else{
              $response .= ' '.trans('app.image_not_uploaded');
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
            return view('admin.brand.form',compact('item'));  
            
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
              return redirect('/admin/brand')->withErrors($response);
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
            
            $response = trans('app.brand').' '.trans('app.deleted_success');
                                                
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
              return redirect('/admin/brand')->withErrors($response);
            }  
          
        }  
    }
    public function uploadImage(Request $request){
      
        $user_id = Auth::user()->id;

        if ($request->hasFile('images')){
            $image = $request->file('images');
            $valid_extensions = ['jpg','jpeg','png'];

            if ( ! in_array(strtolower($image->getClientOriginalExtension()), $valid_extensions) ){
                return ['success' => 0, 'msg' => implode(',', $valid_extensions).' '.trans('app.valid_extension_msg')];
            }

            $file_base_name = str_replace('.'.$image->getClientOriginalExtension(), '', $image->getClientOriginalName());

            $resized = Image::make($image)->resize(640, null, function ($constraint) {
                $constraint->aspectRatio();
            })->stream();
            $resized_thumb = Image::make($image)->resize(320, 213)->stream();

            $image_name = strtolower(time().str_random(5).'-'.str_slug($file_base_name)).'.' . $image->getClientOriginalExtension();

            $imageFileName = 'uploads/images/'.$image_name;
            $imageThumbName = 'uploads/images/thumbs/'.$image_name;

            try{
                //Upload original image
                $is_uploaded = current_disk()->put($imageFileName, $resized->__toString(), 'public');

                if ($is_uploaded) {
                    //Save image name into db
                    $created_img_db = Media::create(['user_id' => $user_id, 'media_name'=>$image_name, 'type'=>'image', 'storage' => get_option('default_storage'), 'ref'=>'ad']);

                    //upload thumb image
                    current_disk()->put($imageThumbName, $resized_thumb->__toString(), 'public');
                    $img_url = media_url($created_img_db, false);
                    return ['success' => 1, 'img_url' => $img_url];
                } else {
                    return ['success' => 0];
                }
            } catch (\Exception $e){
                return $e->getMessage();
            }

        }
    }
}
