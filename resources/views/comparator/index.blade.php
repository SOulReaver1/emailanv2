@extends('layouts.app')
@section('card-header')
    <h1 class="text-underline">Liste des comparaisons</h1>
@endsection
@section('card-body')
    <table id="comparatorTable" class="table w-100 dt-table responsive display nowrap">
        <thead class="thead-light">
            <tr>
                <th scope="col" class="sort" data-sort="id">#</th>
                <th scope="col" class="sort" data-sort="Path">Path</th>
                <th scope="col" class="sort" data-sort="Action">Action</th>
            </tr>
        </thead>
        <tbody class="list">
            
            @foreach ($comparators as $comparator)
                <tr>
                    <th>{{$comparator->id}}</th>
                    <th>{{$comparator->path}}</th>
                    <th>@if ($comparator->statut == 0)
                        <a href="{{asset($comparator->path)}}" download class="btn btn-primary">Télécharger</a>
                    @else
                        <button type="button" class="btn btn-danger">En attente</button>
                    @endif </th>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection