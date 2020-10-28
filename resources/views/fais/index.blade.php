@extends('layouts.app', ['title' => 'Liste des FAIS'])
@section('card-body')
<div class="table-responsive overflow-hidden">
    <table id="fai_table" class="table table-bordered table-striped w-100">
        <thead>
        <tr>
            <th>ID</th>
            <th>Fai</th>
            <th>Domaines</th>
            <th width="10%">Actions</th>
        </tr>
        </thead>
    </table>
</div>
<div class="btn-group my-3" role="group">
    <a class="btn btn-primary text-white" href="{{route('fais.create')}}">Créer un FAI</a>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){ 
        $('#fai_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{route('datatable.fais')}}',
                method: 'POST'
            },
            columns: [
                {
                    'data':'id',
                    'name':'id',
                },
                {
                    'data':'name',
                    'name':'name',
                },
                {
                    'data':'domains',
                    'name':'domains',
                },
                {
                    target: 3,
                    search: false,
                    render: (data, type, full, meta) => {
                        data = `<a href="/fais/${full.id}"" class="btn btn-primary">Actions</a>`;
                        return data;
                    }
                }               
            ]
        });
    });
</script>
@endsection