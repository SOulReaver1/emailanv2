@extends('layouts.app', ['require' => true, 'title' => 'Importer une base'])
@section('card-body')
<form action="#" method="post" class="form-horizontal" enctype="multipart/form-data" id='myForm'>
    {{ csrf_field() }}
    <div class="form-group">
        <h3 class="form-control-label">Mode d'importation : <span class="text-danger">*</span></h3>
        <div class="custom-control custom-radio custom-control-inline">
        <input class="custom-control-input" type="radio" name="importMode" id="inlineRadio1" value="normal">
            <label class="custom-control-label" for="inlineRadio1">Normal</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input class="custom-control-input" type="radio" name="importMode" id="inlineRadio2" value="speed" checked>
            <label class="custom-control-label" for="inlineRadio2">Rapide</label>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label for="base">Choisi ta base : <span class="text-danger">*</span></label>
        <select class="form-control" id="base" name="base" required style="cursor: pointerr">
            @foreach ($bases as $base)
                <option value="{{$base->id}}">{{$base->name}}</option>
            @endforeach
        </select>
        <small> <a href="{{route('bases.create')}}">Créer une base</a></small>
    </div>
    <div class="form-group">
        <label for="file">Choisi ton fichier : <span class="text-danger">*</span></label>
        <input type="file" class="form-control-file" id="file" name="file" required>
    </div>
    <button type="submit" class='btn btn-primary d-flex align-items-center justify-content-center' id="myButton">
        <i class="fa fa-spinner fa-spin" id="loader" style="display:none;margin-right:8px;"></i>
        Importer
    </button>
    <div class="progress mt-4" style="height: 20px;">
        <div class="progress-bar progress-bar-striped" id='progress-bar' role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</form>
@endsection
@section('scripts')
    <script src="{{asset('js/emails/create.js')}}"></script>
@endsection