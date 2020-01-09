@extends('layouts.admin.main')

@section('main')

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
          {{isset($item->id)?trans('app.edit'):trans('app.create')}}
          
          {{trans('app.measure')}}
        </h1>
      </div>
  <br />    
  
      @include('admin.flash_msg')
    

{!! Form::open(['url' => 'admin/measure']) !!}

    @if(isset($item->id))
    <div class="form-row">
      <div class="form-group col-md-2 "></div>
      <div class="form-group col-md-6">
        <label for="type_id">ID:</label>
        {{$item->id}}        
      </div>
      <div class="form-group col-md-3"></div>
    </div> 
    <input type="hidden" value="{{$item->id}}" name="id" />
    @endif

    <div class="form-row">
      <div class="form-group col-md-2"></div>
      <div class="form-group col-md-6">
        <label for="name">{{trans('app.name')}} *</label>
        <input type="text" name="name" value="{{ old('name',isset($item->name)?$item->name:' ') }}" class="form-control {{ $errors->has('name')? 'is-invalid':'' }}" id="name" placeholder="">
        {!! $errors->has('name')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('name').'</small>':'' !!}
      </div>
      <div class="form-group col-md-3"></div>
    </div>
    
    <div class="form-row">
      <div class="form-group col-md-2"></div>
      <div class="form-group col-md-6">
        <label for="abbrev">{{trans('validation.attributes.abbrev')}} *</label>
        <input type="text" name="abbrev" value="{{ old('abbrev',isset($item->abbrev)?$item->abbrev:' ') }}" class="form-control {{ $errors->has('abbrev')? 'is-invalid':'' }}" id="abbrev" placeholder="">
        {!! $errors->has('abbrev')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('abbrev').'</small>':'' !!}
      </div>
      <div class="form-group col-md-3"></div>
    </div>
    
    <div class="form-row">
      <div class="form-group col-md-2"></div>
      <div class="form-group col-md-6">
        <button type="submit" class="btn btn-primary">{{trans('app.save')}}</button>
      </div>
      <div class="form-group col-md-3"></div>
    </div>

  
{{ Form::close() }}


</main>
@endsection