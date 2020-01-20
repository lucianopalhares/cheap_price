@extends('layouts.admin.main')

@section('main')

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
          {{isset($item->id)?isset($show)?trans('app.show'):trans('app.edit'):trans('app.create')}}
          
          {{trans('app.product')}}
        </h1>
      </div>
  <br />    
  
      @include('admin.flash_msg')
    

{!! Form::open(['url' => 'admin/product','files'=>true]) !!}

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
      <div class="form-group col-md-2 "></div>
      <div class="form-group col-md-3">
        <label for="sub_category_id">{{trans('app.sub_category')}} *</label>
        <select {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('sub_category_id')? 'is-invalid':'' }}" required="required" id="sub_category_id" name="sub_category_id">
          <option value="">            
            {{trans('app.select')}} {{trans('validation.attributes.sub_category_id')}}
          </option>
          @foreach($sub_categories as $sub_category)
            <option value="{{$sub_category->id}}" {{ old('sub_category_id') == $sub_category->id ? "selected='selected'" : isset($item->sub_category_id) && $item->sub_category_id == $sub_category->id ? "selected='selected'" : '' }}>
              {{$sub_category->name}}
            </option>
          @endforeach
        </select>
        {!! $errors->has('sub_category_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('sub_category_id').'</small>':'' !!}
      </div>
      <div class="form-group col-md-1">
        <label for="measure">&nbsp; </label> 
        <input {{isset($show)?"disabled='disabled'":''}} type="text" name="measure_number" required="required" value="{{ old('measure_number',isset($item->measure_number)?$item->measure_number:' ') }}" class="form-control {{ $errors->has('measure_number')? 'is-invalid':'' }}" id="measure_number" placeholder="">
        {!! $errors->has('measure_number')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('measure_number').'</small>':'' !!}
      </div>
      <div class="form-group col-md-2"> 
        <label for="measure">{{trans('app.measure')}} *</label>   
        <select {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('measure_id')? 'is-invalid':'' }}" required="required" id="measure_id" name="measure_id">
          <option value="">            
            {{trans('app.select')}} 
          </option>
          @foreach($measures as $measure)
            <option value="{{$measure->id}}" {{ old('measure_id') == $measure->id ? "selected='selected'" : isset($item->measure_id) && $item->measure_id == $measure->id ? "selected='selected'" : '' }}>
              {{$measure->abbrev}} <small><i>({{$measure->name}})</i></small>
            </option>
          @endforeach
        </select>
        {!! $errors->has('measure_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('measure_id').'</small>':'' !!}
      </div>
      <div class="form-group col-md-3"></div>
    </div>  


    <div class="form-row">
      <div class="form-group col-md-2 "></div>
      <div class="form-group col-md-3">
        <label for="model">{{trans('validation.attributes.model')}} </label>
        <input {{isset($show)?"disabled='disabled'":''}} type="text" name="model" value="{{ old('model',isset($item->model)?$item->model:' ') }}" class="form-control {{ $errors->has('model')? 'is-invalid':'' }}" id="model" placeholder="">
        {!! $errors->has('model')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('model').'</small>':'' !!}
      </div>
      <div class="form-group col-md-3">
        <label for="brand_id">{{trans('app.brand')}} </label>
        <select {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('brand_id')? 'is-invalid':'' }}" id="brand_id" name="brand_id">
          <option value="">            
            {{trans('app.select')}} {{trans('validation.attributes.brand_id')}}
          </option>
          @foreach($brands as $brand)
            <option value="{{$brand->id}}" {{ old('brand_id') == $brand->id ? "selected='selected'" : isset($item->brand_id) && $item->brand_id == $brand->id ? "selected='selected'" : '' }}>
              {{$brand->name}}
            </option>
          @endforeach
        </select>
        {!! $errors->has('brand_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('brand_id').'</small>':'' !!}
      </div>
      <div class="form-group col-md-3"></div>
    </div>  
    
    <div class="form-row">
      <div class="form-group col-md-2 "></div>
      <div class="form-group col-md-6">
        <label for="description">{{trans('validation.attributes.description')}}:</label>
        <textarea {{isset($show)?"disabled='disabled'":''}} name="description" class="form-control" rows="1">{{ old('description',isset($item->description)?$item->description:' ') }}</textarea>
      </div>
      <div class="form-group col-md-3"></div>
    </div> 
    
    <div class="form-row">
      <div class="form-group col-md-2 "></div>
      <div class="form-group col-md-6">
        <label for="description">{{trans('app.image')}}:</label>
        <input {{isset($show)?"disabled='disabled'":''}} type="file" name="image" class="form-control">
      </div>
      <div class="form-group col-md-3">
      </div>
    </div> 
    @if(isset($item->id))
    <div class="form-row">
      <div class="form-group col-md-2 "></div>
      <div class="form-group col-md-6">
        <label for="description"></label>
        <img src="/images/products/thumbs/{{$item->image}}" width="100" alt="">
      </div>
      <div class="form-group col-md-3">
      </div>
    </div> 
    @endif
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
            url: "{{url('admin/product')}}"+"/"+id,
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