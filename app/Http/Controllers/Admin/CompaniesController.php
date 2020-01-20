<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use \App;
use Auth;

class CompaniesController extends Controller
{
    protected $model;
    protected $companyType;
    protected $title;
    protected $path_view;
    
    public function __construct(){
      $this->title = trans('app.company');
      $this->path_view = 'admin.company';
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
          return view($this->path_view.'.index',compact('items'));
        }else{
          $items = $this->model::whereUserId(Auth::user()->id)->paginate(10);
          return view($this->path_view.'.index',compact('items'));
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
        return view($this->path_view.'.form',compact('companyTypes'));
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

        if($update){

            $model = $this->model->findOrFail($request->id);
                
        }else{
            $model = new App\Company;
        }
        $model->name = $request->name;
        $model->company_type_id = $request->company_type_id;
        $model->user_id = Auth::user()->id;
            
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

        if (!Auth::user()->isAdmin()) {
          if (Auth::user()->company->id != $item->id) {
            return back()->withErrors(trans('app.notyour_company'));
          }
        }  
            
        $companyTypes = $this->companyType::all();
        return view($this->path_view.'.form',compact('item','companyTypes','show'));  
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
        return view($this->path_view.'.form',compact('item','companyTypes'));  
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
