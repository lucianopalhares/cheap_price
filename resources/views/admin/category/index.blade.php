@extends('layouts.admin.main')

@section('main')

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">          
          {{trans('app.categories')}}
        </h1>
      </div>
  <br />    
  
      @include('admin.flash_msg')
      
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
           
      </td>
    </tr>
    @endforeach
  </tbody>
</table>     

  

      {{ $items->links() }}
      

</main>

@endsection

@section('page-js')



  
@endsection