@extends('layouts.app', ['title' => 'Liste des bases'])
@section('card-body')
<div class="table-responsive overflow-hidden">
    <table id="user_table" class="table table-bordered table-striped w-100">
        <thead>
        <tr>
            <th>Base</th>
            <th width=5%>Actions</th>
        </tr>
        </thead>
    </table>
</div>
<div class="btn-group my-3" role="group">
    <a class="btn btn-primary text-white" href="{{route('create')}}">Importer une base</a>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){ 
        $('#user_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('datatable.bases') }}",
            },
            columns: [
                {
                    "data": 'name',
                    "name": "name",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = `<a href="/bases/${row.id}">${data} ${row.statut === 0 ? '' : '(emails en cours d\'importations)'}</a>`;
                        }
                        return data;
                    }
                },
                {
                    target: 1,
                    search: false,
                    render: (data, type, full, meta) => {
                        // Je créer les différents logos d'actions
                        data = `<div><i class='fas fa-edit text-primary' role='button' data-toggle='modal' data-target='#edit${full.id}Modal'></i><i class='fas fa-trash ml-2 text-danger' role='button' data-toggle='modal' data-target='#delete${full.id}Modal'></i></div>`;
                        // Je créer la modal pour le edit
                        data += `
                        <form action="/base/${full.id}" method="post">
                            @csrf
                            @method('put')
                            <div class="modal fade" id="edit${full.id}Modal" tabindex="-1" role="dialog" aria-labelledby="edit${full.id}ModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="edit${full.id}ModalLabel">Edit ${full.name}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="baseId" value="${full.id}">
                                            <div class="form-group">
                                                <label for="editbase">Modifier la base</label>
                                                <input class="form-control" type="text" value="${full.name}" name="base" id="edit${full.id}base">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success">Edit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        `;
                        // Je créer la modal pour le delete
                        data += `
                        <form action='/base/${full.id}' method='post'>
                            @csrf
                            @method('delete')
                            <div class="modal fade" id="delete${full.id}Modal" tabindex="-1" role="dialog" aria-labelledby="delete${full.id}ModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-danger" id="delete${full.id}ModalLabel">Delete ${full.name}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-danger">
                                            <input type="hidden" name="baseId" value="${full.id}">
                                            WARNING ! You will delete ${full.name} !
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        `;
                        return data;
                        
                    }
                }
                
               
            ]
        });
    });
</script>
@endsection