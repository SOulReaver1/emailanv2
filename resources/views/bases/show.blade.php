@extends('layouts.app')
@section('card-header')
    <h1 class="text-underline">Vous regarder la base {{$base->name}}</h1>
@endsection
@section('card-body')
<div class="table-responsive overflow-hidden">
    <table id="list_table" class="table table-bordered table-striped w-100">
        <thead>
        <tr>
            <th width='5%'>Id</th>
            <th width='40%'>Emails</th>
            <th>Tags</th>
            <th width="5%">Actions</th>
        </tr>
        </thead>
    </table>
</div>
<div class="btn-group my-3" role="group">
    <a class="btn btn-primary text-white" href="/destinataire/create">Importer des emails</a>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){ 
        $('#list_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route("datatable.emails") }}',
                type: 'POST',
                data: {
                    id: "{{$base->id}}"
                },
            },
            columns: [
                {
                    'data': 'id',
                    'name': 'id'
                },
                {
                    "data": 'email',
                    "name": "email",
                },
            ],
            
        });
    });
</script>
@endsection