@extends('layouts.admin')

@section('titre', 'Modifier l\'Enseignant')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Modifier l\'enseignant : {{ $enseignant->nom }} {{ $enseignant->prenom }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('personnes.enseignants.update', $enseignant) }}" method="POST">
            @method('PUT')
            @include('personnes.enseignants._form')
        </form>
    </div>
</div>
@endsection

