@extends('layouts.app', ['require' => true, 'title' => 'Créer une base'])
@section('card-body')
<form action="{{route('bases.store')}}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="form-group">
      <label for="basename" id="baseNameLabel">Nom de la base : <span class="text-danger">*</span></label>
      <input type="text" class="form-control" id="basename" aria-describedby="baseHelp" name='name' onkeyup="$(`#basename`).val($(`#basename`).val().split(' ').join('_'));" required>
    </div>
    <button type="submit" class="btn btn-primary">Créer</button>
</form>
@endsection