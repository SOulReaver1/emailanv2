@extends('layouts.app', ['require' => true, 'title' => 'Importer des tags'])
@section('card-body')
<div class="form-group">
    <h3 class="form-control-label">Mode d'importation : <span class="text-danger">*</span></h3>
    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input" checked value="base">
        <label class="custom-control-label" for="customRadioInline1">Ajouter à partir d'une base</label>
    </div>
    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input" value="file">
        <label class="custom-control-label" for="customRadioInline2">Ajouter à partir d'un fichier</label>
    </div>
    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" id="customRadioInline3" name="customRadioInline1" class="custom-control-input" disabled value="domains">
        <label class="custom-control-label" for="customRadioInline3">Ajouter à partir d'un nom de domain</label>
    </div>
</div>
<hr>
<form action="" method="post" enctype="multipart/form-data" id='myForm'>
    {{ csrf_field() }}
    <div class="form-group">
        <div class="ui sub header">Base(s) <span class="text-danger">*</span></div>
        <select name="bases" multiple="" class="ui fluid dropdown" id='base'>
            @foreach ($bases as $key => $base)
                <option value="{{$base->id}}">{{$base->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group mt-2">
        <div class="ui sub header">Tag(s) <span class="text-danger">*</span></div>
        <div class="ui fluid multiple search selection dropdown" id='dropdown'>
            <input name="tags" type="hidden" id='aa'>
            <i class="dropdown icon"></i>
            <div class="default text">Exemple</div>
            <div class="menu">
                @foreach ($tags as $tag)
                    <div class="item" data-value="{{$tag->name}}">{{$tag->name}}</div>
                @endforeach
            </div>
        </div>
        <small id="tagHelp" class="form-text text-muted">Pour créer plusieurs tags, il suffit de les séparés par une virgule</small>
    </div>
    <div class="form-group" id='methodFile' style="display:none;">
        <label for="file">Choisir son fichier <span class="text-danger">*</span></label>
        <input type="file" class="form-control-file" id="file" name="file">
    </div>
    <button type="submit" class='btn btn-primary d-flex align-items-center justify-content-center' id="myButton">
        <i class="fa fa-spinner fa-spin" id="loader" style="display:none;margin-right:8px;"></i>
        Importer
    </button>
</form>
<div class="progress mt-4" style="height: 20px;">
    <div class="progress-bar progress-bar-striped" id='progress-bar' role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
@endsection
@section('scripts')
<link rel="stylesheet" type="text/css" href="{{asset('semantic/semantic.min.css')}}">
<script src="{{asset('semantic/semantic.min.js')}}"></script>
<script src="{{asset('js/tags/create.js')}}"></script>
@endsection