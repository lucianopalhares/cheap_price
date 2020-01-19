<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Validation\Rule;
use \App;
use Auth;

class CompaniesController extends Controller
{
    protected $model;
    protected $companyType;
    
    public function __construct(){
      $this->model = App::make('App\Company');
      $this->companyType = App::make('App\CompanyType');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
          $items = $this->model::paginate(10);
          return view('admin.company.index',compact('items'));
        }else{
          $items = $this->model::whereUserId(Auth::user()->id)->paginate(10);
          return view('admin.company.index',compact('items'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->isAdmin() && Auth::user()->company()->count()>0) {
          return back()->withErrors(trans('app.has_company'));
        }
        $companyTypes = $this->companyType::all();
        return view('admin.company.form',compact('companyTypes'));
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
              'name' =>  'required|max:100',
              'company_type_id' => 'required'
          ];            
          
        }else{
          
          $rules = [
              'name' =>  'required|max:100',
              'company_type_id' => 'required'
          ];          
        }

        $this->validate($request, $rules);

        $slug = str_slug($request->name);

        try {

            if($update){

                $model = $this->model->findOrFail($request->id);
                
            }else{
                $model = new App\Company;
            }
            $model->name = $request->name;
            $model->company_type_id = $request->company_type_id;
            $model->user_id = Auth::user()->id;
            
            $save = $model->save();
            
            $response = trans('app.company').' ';
            
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
        $item = $this->model->findOrFail($id);

        if (!Auth::user()->isAdmin()) {
          if (Auth::user()->company->id != $item->id) {
            return back()->withErrors(trans('app.notyour_company'));
          }
        }  
            
        $companyTypes = $this->companyType::all();
        return view('admin.company.form',compact('item','companyTypes'));  
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
            
            $response = trans('app.company').' '.trans('app.deleted_success');
                                                
            if (request()->wantsJson()) {
              return response()->json(['status'=>true,'msg'=>$response]);
            }else{
              return back()->with('success', $response);
            }    

    }
}
