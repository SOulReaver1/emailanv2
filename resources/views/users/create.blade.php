@extends('layouts.app')
@section('card-header')
<div class="row">
    <div class="col-lg-6">
        <h1 class="text-underline">Gestion des utilisateurs</h1>
    </div>
    <div class="col-lg-6 text-right">
        <button class="btn btn-info text-right" data-toggle="modal" data-target="#addUserModal">Ajouter un utilisateur</button>
    </div>
</div>
@endsection
@section('card-body')
    <table id="usersTable" class="table w-100 dt-table responsive display nowrap">
        <thead class="thead-light">
            <tr>
                <th scope="col" class="sort" data-sort="id">#</th>
                <th scope="col" class="sort" data-sort="Name">Nom</th>
                <th scope="col" class="sort" data-sort="Email">Email</th>
            </tr>
        </thead>
        <tbody class="list">
            
            @foreach ($users as $user)
                <tr>
                    <th>{{$user->id}}</th>
                    <th>{{$user->name}}</th>
                    <th>{{$user->email}}</th>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="modal fade text-left" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <form action="{{route('user.store')}}" method="post">
            {{ csrf_field() }}
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Ajouter un utilisateur</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <small class="mb-5"><span class="text-danger">*</span> champs obligatoires</small>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="userAddName" class="form-control-label">Nom :  <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" id="userAddName" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="userAddEmail" class="form-control-label">Email :  <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="userAddEmail" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="userAddPassword" class="form-control-label">Mot de passe :  <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="userAddPassword" class="form-control" required confirmed>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="userAddPasswordConfirm" class="form-control-label">Confirmer le mot de passe :  <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" id="userAddPasswordConfirm" class="form-control" required>
                                </div>
                            </div>
                        </div>                  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Créer l'utilisateur</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection