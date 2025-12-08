@extends('layouts.admin')

@section('titre', 'Modifier la Filière')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Modifier la filière : {{ $filiere->nom }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('academique.filieres.update', $filiere) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('academique.filieres._form')
        </form>
    </div>
</div>
@endsection
