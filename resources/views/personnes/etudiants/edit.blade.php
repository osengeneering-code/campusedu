@extends('layouts.admin')

@section('titre', 'Modifier l\'Étudiant')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Modifier l\'étudiant : {{ $etudiant->nom }} {{ $etudiant->prenom }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('personnes.etudiants.update', $etudiant) }}" method="POST">
            @method('PUT')
            @include('personnes.etudiants._form')
        </form>
    </div>
</div>
@endsection
