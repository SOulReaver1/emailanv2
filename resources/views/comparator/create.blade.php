@extends('layouts.app', ['require' => true])
@section('card-header')
    <h1 class="text-underline">Créer une comparaison</h1>
@endsection
@section('card-body')
<div class="form-group">
    <h3 class="form-control-label">Mode de comparaison : <span class="text-danger">*</span></h3>
    <div class="custom-control custom-radio custom-control-inline">
    <input class="custom-control-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="fileMethod" checked onclick="$('#fileForm').css({display: 'block'});$('#dbForm').css({display: 'none'})">
        <label class="custom-control-label" for="inlineRadio1">Depuis un fichier</label>
    </div>
    <div class="custom-control custom-radio custom-control-inline">
        <input class="custom-control-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="dbMethod" onclick="$('#fileForm').css({display: 'none'});$('#dbForm').css({display: 'block'})">
        <label class="custom-control-label" for="inlineRadio2">Depuis la base de données</label>
    </div>
</div>
<hr>
<form action="" method="post" id='fileForm'>
    {{ csrf_field() }}
    <div class="form-group">
        <label for="file1">Fichier 1 : <span class="text-danger">*</span></label>
        <input type="file" class="form-control-file" id="file1" name="file1" required>
    </div>
    <div class="form-group">
        <label for="file2">Fichier 2 : <span class="text-danger">*</span></label>
        <input type="file" class="form-control-file" id="file2" name="file2" required>
    </div>
    <div class="form-group">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="checkbox">
            <label class="form-check-label" for="checkbox">Exporter les mails qui n'ont pas matchés</label>
        </div>
    </div>
    <div class="form-group">
        <button type="button" class="btn btn-primary d-flex align-items-center justify-content-center text-white"><i class="fa fa-spinner fa-spin" id="loader" style="display:none;margin-right:8px;"></i>Comparer</button>
    </div>
</form>
<form action="" method="post" id='dbForm' style="display: none">
    <div class="form-group">
        <label for="dbFile">Ton fichier : <span class="text-danger">*</span></label>
        <input type="file" class="form-control-file" id="dbFile" name="file" required>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center text-white" id="dbButton"><i class="fa fa-spinner fa-spin" id="loader" style="display:none;margin-right:8px;"></i>Comparer</button>
    </div>
    <div class="progress mt-4" style="height: 20px;">
        <div class="progress-bar progress-bar-striped" id='progress-bar' role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</form>
@endsection
@section('scripts')
    <script src="{{asset('js/comparator/db.js')}}"></script>
@endsection