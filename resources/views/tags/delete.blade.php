@extends('layouts.app', ['require' => true, 'title' => 'Supprimer des tags'])
@section('card-body')
<form action="{{route('tags.destroy')}}" method="post" enctype="multipart/form-data" id='myForm'>
    {{ csrf_field() }}
    @method('delete')
    <div class="form-group">
        <div class="ui sub header">Choisi ta/tes base(s) : <span class="text-danger">*</span></div>
        <select name="bases" multiple="" class="ui fluid dropdown" id='base'>
            @foreach ($bases as $key => $base)
                <option value="{{$base->id}}">{{$base->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group mt-2">
        <div class="ui sub header">Choisi ton/tes tag(s) à supprimer : <span class="text-danger">*</span></div>
        <div class="ui fluid multiple search selection dropdown" id='dropdown'>
            <input name="elements" type="hidden" id='aa'>
            <i class="dropdown icon"></i>
            <div class="default text">Tags</div>
            <div class="menu">
                @foreach ($tags as $tag)
                    <div class="item" data-value="{{$tag->name}}">{{$tag->name}}</div>
                @endforeach
            </div>
        </div>
        <small id="tagHelp" class="form-text text-muted">Pour créer plusieurs tags, il suffit de les séparés par une virgule</small>
    </div>
    <div class="form-group">
        <button type="button" class="btn btn-primary">Delete</button>
    </div>
</form>
@endsection
@section('scripts')
<link rel="stylesheet" type="text/css" href="{{asset('semantic/semantic.min.css')}}">
<script src="{{asset('semantic/semantic.min.js')}}"></script>
<script>
$('#base').dropdown({
    onChange: function(array, id, val){
        bases = array;
    }
});
$('#dropdown').dropdown({
    allowAdditions: true,
    onChange: function(val){
        tags = val.split(',');
    }
});
</script>
@endsection