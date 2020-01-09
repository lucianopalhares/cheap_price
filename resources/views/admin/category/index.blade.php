@extends('layouts.admin.main')

@section('main')

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">          
          {{trans('app.categories')}}
        </h1>
      </div>
  <br />    
  
  
  <div class="flash_msg">
    @include('admin.flash_msg')
  </div>      

                  
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">{{trans('app.name')}}</th>
      <th scope="col">Slug</th>
      <th scope="col">{{trans('app.type')}}</th>
      <th scope="col">
        <span data-feather="settings"></span>
      </th>
    </tr>
  </thead>
  <tbody>
    @foreach($items as $item)
    <tr>
      <th scope="row">{{$item->id}}</th>
      <td>{{$item->name}}</td>
      <td>{{$item->slug}}</td>
      <td>{{$item->type->name}}</td>
      <td>
        <a href="{{url('admin/category/'.$item->id.'/edit')}}"><span data-feather="edit"></span></a>
          <a href="javascript:void" id="delete_item" data-id="{{ $item->id }}" onclick="confirm('{{trans('app.are_you_sure')}}')"><span data-feather="trash"></span></a>
               
      </td>
    </tr>
    @endforeach
  </tbody>
</table>     

  

      {{ $items->links() }}
      

</main>

@endsection

@section('page-js')

<script>
  


  jQuery(document).ready(function(){
      console.log( "ready!" );

    $("#delete_item").click(function(e){
        
        var id = $(this).data("id");
        e.preventDefault();
        var token = $("meta[name='csrf-token']").attr("content");
        var url = e.target;
               
        $.ajax(
        {
          url: "category/"+id, //or you can use url: "company/"+id,
          type: 'DELETE',
          dataType: "json",
          data: {
            _token: token,
                id: id
              },
            success: function (data){
              if(data.true){
                //$( ".flash_msg" ).html('<div class="alert alert-success text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.msg+'</div>');
                location.reload();
              }else{
                $( ".flash_msg" ).html('<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.msg+'</div>');
              }
            }
        });
       
    });
  });
</script>
@endsection