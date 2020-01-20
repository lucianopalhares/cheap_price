@extends('layouts.admin.main')

@section('main')

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
          {{isset($item->id)?isset($show)?trans('app.show'):trans('app.edit'):trans('app.create')}}
          
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
        <input {{isset($show)?"disabled='disabled'":''}} type="text" name="name" value="{{ old('name',isset($item->name)?$item->name:' ') }}" class="form-control {{ $errors->has('name')? 'is-invalid':'' }}" id="name" placeholder="">
        {!! $errors->has('name')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('name').'</small>':'' !!}
      </div>
      <div class="form-group col-md-3"></div>
    </div>
    
    <div class="form-row">
      <div class="form-group col-md-2"></div>
      <div class="form-group col-md-6">
        <label for="abbrev">{{trans('validation.attributes.abbrev')}} *</label>
        <input {{isset($show)?"disabled='disabled'":''}} type="text" name="abbrev" value="{{ old('abbrev',isset($item->abbrev)?$item->abbrev:' ') }}" class="form-control {{ $errors->has('abbrev')? 'is-invalid':'' }}" id="abbrev" placeholder="">
        {!! $errors->has('abbrev')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('abbrev').'</small>':'' !!}
      </div>
      <div class="form-group col-md-3"></div>
    </div>
    
    <div class="form-row">
      <div class="form-group col-md-2"></div>
      <div class="form-group col-md-6">
        @if (strpos(Route::currentRouteName(), 'create') !== false || strpos(Route::currentRouteName(), 'edit') !== false)
          <button type="submit" class="btn btn-primary">{{trans('app.save')}}</button>
        @endif

        @if(isset($item->id))
          <a href="" class="btn btn-danger" id="delete_item" data-id="{{ $item->id }}">{{trans('app.delete')}}</a>
        @endif    
      </div>
      <div class="form-group col-md-3"></div>
    </div>

  
{{ Form::close() }}


</main>
@endsection


@section('page-js')

<script>

  jQuery(document).ready(function(){

    $("a#delete_item").click(function(e){
              
        var id = $(this).data("id");
        e.preventDefault();
        var token = $("meta[name='csrf-token']").attr("content");
        var url = e.target;
                
        if (confirm("{{trans('app.are_you_sure')}}")) {
          
          $.ajax({
            url: "{{url('admin/measure')}}"+"/"+id,
            type: 'DELETE',
            dataType: "json",
            data: {
              _token: token,
                  id: id
                },
              success: function (data){
                
                if(data.status){
                  $( ".flash_msg" ).html('<div class="alert alert-success text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.msg+'</div>');
              
                  setInterval('location.reload()',1000);
                }else{
                  $( ".flash_msg" ).html('<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.msg+'</div>');
                }
              }
          });
      }
    });
  });
</script>
@endsection