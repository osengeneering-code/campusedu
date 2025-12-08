@extends('layouts.admin')

@section('titre', 'Détails de la faculté')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Détails de la faculté</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <td>{{ $faculte->id }}</td>
                            </tr>
                            <tr>
                                <th>Nom</th>
                                <td>{{ $faculte->nom }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $faculte->description }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
