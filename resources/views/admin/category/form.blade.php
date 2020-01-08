@extends('layouts.admin.main')

@section('main')

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
          {{isset($category->id)?'Editar':'Cadastrar'}}
          Categoria
        </h1>
      </div>
  <br />    
  
      @include('admin.flash_msg')
      
<form>
  

    @if(isset($category->id))
    <div class="form-row">
      <div class="form-group col-md-2 "></div>
      <div class="form-group col-md-6">
        <label for="type_id">ID:</label>
        {{$category->id}}        
      </div>
      <div class="form-group col-md-3"></div>
    </div> 
    @endif
    
    <div class="form-row">
      <div class="form-group col-md-2 "></div>
      <div class="form-group col-md-6">
        <label for="type_id">Tipo da Categoria *</label>
        <select class="form-control {{ $errors->has('type_id')? 'is-invalid':'' }}" id="type_id" name="type_id">
          <option value="">            
            Selecione o Tipo da Categoria
          </option>
          @foreach($types as $type)
            <option value="{{$type->id}}" {{ old('type_id') == $type->id ? "selected='selected'" : isset($category->type_id) && $category->type_id == $type->id ? "selected='selected'" : '' }}>
              {{$type->name}}
            </option>
          @endforeach
        </select>
        {!! $errors->has('type_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('type_id').'</small>':'' !!}
      </div>
      <div class="form-group col-md-3"></div>
    </div>  
    <div class="form-row">
      <div class="form-group col-md-2"></div>
      <div class="form-group col-md-6">
        <label for="name">Nome da Categoria *</label>
        <input type="text" class="form-control {{ $errors->has('name')? 'is-invalid':'' }}" id="name" placeholder="Nome da Categoria">
        {!! $errors->has('name')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('name').'</small>':'' !!}
      </div>
      <div class="form-group col-md-3"></div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-3"></div>
      <div class="form-group col-md-6">
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
      <div class="form-group col-md-3"></div>
    </div>

  
</form>


</main>
@endsection