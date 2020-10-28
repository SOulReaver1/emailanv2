@extends('layouts.app')
@section('card-header')
    <h1 class="text-underline text-capitalize">{{ $fais->name }}</h1>
@endsection
@section('card-body')
<div class="list-group">
    @foreach (explode(', ', $fais->domains) as $key => $value)
        <div class="list-group-item list-group-item-action d-flex justify-content-between">
            <a href="https://{{$value}}" target="_blank">
                {{$value}}
            </a>
            <div>
                <i class="fas fa-edit text-primary" role="button" data-toggle="modal" data-target="#edit{{$key}}Modal"></i>
                <i class="fas fa-trash ml-2 text-danger" role="button" data-toggle="modal" data-target="#delete{{$key}}Modal"></i>
            </div>
        </div>
        <!-- Edit a domain -->
        {{-- <form action="" method="post">
            @csrf
            @method('put')

            <div class="modal fade" id="edit{{$key}}Modal" tabindex="-1" role="dialog" aria-labelledby="edit{{$key}}ModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="edit{{$key}}ModalLabel">Edit {{$value}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="faiName" value="{{$id}}">
                            <input class="form-control" type="text" value="{{$value}}" name="domains">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Edit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form> --}}
        <!-- Delete a domain -->
        {{-- <form action="#" method="post">
            @csrf
            @method('delete')
            <div class="modal fade" id="delete{{$key}}Modal" tabindex="-1" role="dialog" aria-labelledby="delete{{$key}}ModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-danger" id="delete{{$key}}ModalLabel">Delete {{$value}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-danger">
                            <input type="hidden" name="faiName" value="{{$id}}">
                            WARNING ! You will delete {{$value}} domain !
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </form> --}}
    @endforeach
</div>
<!-- Modals -->
<!-- Delete the Fai and his domains -->
{{-- <form action="/fais/{{$id}}" method="post">
    @method('delete')
    @csrf
    <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#deleteFaisModal">
        Delete
    </button>

    <div class="modal fade" id="deleteFaisModal" tabindex="-1" role="dialog" aria-labelledby="deleteFaisModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteFaisModalLabel">Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-danger">
                    WARNING ! You will Delete fai !
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
</form> --}}
@endsection