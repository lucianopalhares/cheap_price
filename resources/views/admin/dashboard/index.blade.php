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

    <h2>Título da seção</h2>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>#</th>
            <th>Cabeçalho</th>
            <th>Cabeçalho</th>
            <th>Cabeçalho</th>
            <th>Cabeçalho</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
          </tr>
          
        </tbody>
      </table>
    </div>
  </main>
</div>
</div>
@endsection