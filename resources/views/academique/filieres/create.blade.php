@extends('layouts.admin')

@section('titre', 'Nouvelle Filière')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Ajouter une nouvelle filière</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('academique.filieres.store') }}" method="POST" enctype="multipart/form-data">
            @include('academique.filieres._form')
        </form>
    </div>
</div>
@endsection
