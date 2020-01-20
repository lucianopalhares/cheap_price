@extends('layouts.admin.main')

@section('page-css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
@endsection

@section('main')

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
          {{isset($item->id)?isset($show)?trans('app.show'):trans('app.edit'):trans('app.create')}}
          
          {{trans('app.price')}}
        </h1>
      </div>
  <br />

      @include('admin.flash_msg')


{!! Form::open(['url' => 'admin/price','files'=>true]) !!}

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
    
    <input type="hidden" value="1" name="status" /><!--status PUBLISHED -->

    <div class="form-row">
      <div class="form-group col-md-2 "></div>
      <div class="form-group col-md-4">
        <label for="product_id">{{trans('app.product')}} *</label>
        <select {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('product_id')? 'is-invalid':'' }}" required="required" id="product_id" name="product_id">
          <option value="">
            {{trans('app.select')}} {{trans('validation.attributes.product_id')}}
          </option>
          @foreach($products as $product)
            <option value="{{$product->id}}" {{ old('product_id') == $product->id ? "selected='selected'" : isset($item->product_id) && $item->product_id == $product->id ? "selected='selected'" : '' }}>
              {{$product->name()}}
            </option>
          @endforeach
        </select>
        {!! $errors->has('product_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('product_id').'</small>':'' !!}
      </div>
      <div class="form-group col-md-2">
        <label for="price">{{trans('app.price')}} *</label>
        <input {{isset($show)?"disabled='disabled'":''}} type="text" name="price" required="required" value="{{ old('price',isset($item->price)?$item->price:' ') }}" class="form-control {{ $errors->has('price')? 'is-invalid':'' }}" id="price" placeholder="">
        {!! $errors->has('price')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('price').'</small>':'' !!}
      </div>
      <div class="form-group col-md-3"></div>
    </div>


    <div class="form-row">
      <div class="form-group col-md-2 "></div>
      <div class="form-group col-md-3">
        <label for="date_start">{{trans('validation.attributes.date_start')}} </label>
        <input {{isset($show)?"disabled='disabled'":''}} type="text" name="date_start" value="{{ old('date_start',isset($item->date_start)?$item->date_start:' ') }}" class="form-control {{ $errors->has('date_start')? 'is-invalid':'' }}" id="date_start" placeholder="">
        {!! $errors->has('date_start')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('date_start').'</small>':'' !!}
      </div>
      <div class="form-group col-md-3">
        <label for="date_end">{{trans('validation.attributes.date_end')}} </label>
        <input {{isset($show)?"disabled='disabled'":''}} type="text" name="date_end" value="{{ old('date_end',isset($item->date_end)?$item->date_end:' ') }}" class="form-control {{ $errors->has('date_end')? 'is-invalid':'' }}" id="date_end" placeholder="">
        {!! $errors->has('date_end')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('date_end').'</small>':'' !!}
      </div>
      <div class="form-group col-md-3"></div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
      $('#date_start').datetimepicker({
        format: '{{ config('app.date_format_javascript') }}',
        locale: 'pt-br'
      });
    });
    $(document).ready(function () {
      $('#date_end').datetimepicker({
        format: '{{ config('app.date_format_javascript') }}',
        locale: 'pt-br'
      });
    });

</script>

<script>

  jQuery(document).ready(function(){

    $("a#delete_item").click(function(e){
              
        var id = $(this).data("id");
        e.preventDefault();
        var token = $("meta[name='csrf-token']").attr("content");
        var url = e.target;
                
        if (confirm("{{trans('app.are_you_sure')}}")) {
          
          $.ajax({
            url: "{{url('admin/price')}}"+"/"+id,
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
