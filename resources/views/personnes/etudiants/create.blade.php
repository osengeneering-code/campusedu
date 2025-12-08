@extends('layouts.admin')

@section('titre', 'Nouvel Étudiant')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Ajouter un nouvel étudiant</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('personnes.etudiants.store') }}" method="POST">
            @include('personnes.etudiants._form', ['etudiant' => null])
        </form>
    </div>
</div>
@endsection
