@extends('layouts.app', ["require" => true, 'title' => 'Convertir une liste'])
@section('card-body')
<div class="form-group">
    <h3 class="form-control-label">Mode de chiffrement : <span class="text-danger">*</span></h3>
    <div class="custom-control custom-radio custom-control-inline">
    <input class="custom-control-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="sha256" checked onclick="$('#sha256Form').css({display: 'block'});$('#md5Form').css({display: 'none'})">
        <label class="custom-control-label" for="inlineRadio1">SHA256</label>
    </div>
    <div class="custom-control custom-radio custom-control-inline">
        <input class="custom-control-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="md5" onclick="$('#sha256Form').css({display: 'none'});$('#md5Form').css({display: 'block'})">
        <label class="custom-control-label" for="inlineRadio2">MD5</label>
    </div>
</div>
<hr>
<form action="" method="post" enctype="multipart/form-data" id='sha256Form'>
    {{ csrf_field() }}
    <div class="form-group">
        <label for="file">Ton fichier : <span class="text-danger">*</span></label>
        <input type="file" class="form-control-file" id="file" name="file" required>
    </div>
    <div class="form-group d-flex">
        <i class="fa fa-spinner fa-spin" id='loader' style="display:none;margin-right:8px;"></i>
        <button type="button" class='btn btn-primary align-items-center justify-content-center' id='sha256Button'>En MD5</button>
        <button type="button" class='btn btn-primary d-flex align-items-center justify-content-center' id='emailsButton'></i>En clair</button>
    </div>
</form>

<form action="" method="post" enctype="multipart/form-data" id='md5Form' style="display: none">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="file2">Ton fichier : <span class="text-danger">*</span></label>
        <input type="file" class="form-control-file" id="file2" name="file" required>
    </div>
    <div class="form-group d-flex">
        <i class="fa fa-spinner fa-spin" id='loader' style="display:none;margin-right:8px;"></i>
        <button type="button" class='btn btn-primary align-items-center justify-content-center' id='md5button'>En SHA256</button>
        <button type="button" class='btn btn-primary d-flex align-items-center justify-content-center' id='emails2Button'></i>En clair</button>
    </div>
</form>
<div class="progress mt-4" style="height: 20px;">
    <div class="progress-bar progress-bar-striped" id='progress-bar' role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
@endsection