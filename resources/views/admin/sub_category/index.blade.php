@extends('layouts.admin.main')

@section('main')

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">          
          {{trans('app.sub_categories')}}
        </h1>
      </div>
  <br />    
  
  
  <div class="flash_msg">
    @include('admin.flash_msg')
  </div>      

                  
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">{{trans('app.name')}}</th>
      <th scope="col">Slug</th>
      <th scope="col">{{trans('app.category')}}</th>
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
      <td>{{$item->category->name}}</td>
      <td>
        <a href="{{url('admin/sub_category/'.$item->id.'/edit')}}" class="text-primary"><span data-feather="edit"></span></a>
        <a href="#" class="text-danger" id="delete_item" data-id="{{ $item->id }}"><span data-feather="trash"></span></a>
               
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

    $("a#delete_item").click(function(e){
        
        var id = $(this).data("id");
        e.preventDefault();
        var token = $("meta[name='csrf-token']").attr("content");
        var url = e.target;
        
        if (confirm("{{trans('app.are_you_sure')}}")) {
          
          $.ajax({
            url: "{{url('admin/sub_category')}}"+"/"+id,
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