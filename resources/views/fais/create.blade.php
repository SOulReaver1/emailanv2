@extends('layouts.app', ['require' => true, 'title' => 'Créer un FAI'])
@section('card-body')
<form method="POST" action="{{route('fais.store')}}">
    {{ csrf_field() }}
    <div class="form-group">
      <label for="basename">Nom du FAI <span class="text-danger">*</span></label>
      <input type="text" class="form-control" id="basename" aria-describedby="baseHelp" name='name'>
    </div>
    <div class="form-group">
        <label for="domain">Nom de domaine (si plusieurs, séparer les noms de domaine par une virgule)</label>
        <input type="text" class="form-control" id="domain" name="domains" aria-describedby="domainHelp">
        <small id="domainHelp" class="form-text text-muted">Pour créer plusieurs noms de domaine il suffit de les séparés par une virgule</small>
    </div>
    <button type="submit" class='btn btn-primary'>Créer</button>
</form>
@endsection