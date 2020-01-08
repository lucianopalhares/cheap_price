@extends('layouts.admin.main')

@section('main')

  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Dashboard</h1>
      <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
          <button class="btn btn-sm btn-outline-secondary">Compartilhar</button>
          <button class="btn btn-sm btn-outline-secondary">Exportar</button>
        </div>
        <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
          <span data-feather="calendar"></span>
          Esta semana
        </button>
      </div>
    </div>

    <!--<canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>-->



<div class="card-deck">
  <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
    <div class="card-header"><h4>Bem vindo, {{Auth::user()->first_name}}</h4></div>
    <div class="card-body">
      <h5 class="card-title"></h5>
      <p class="card-text"></p>
    
    </div>
  </div>

</div>



  </main>
</div>
</div>
@endsection