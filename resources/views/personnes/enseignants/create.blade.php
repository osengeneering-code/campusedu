@extends('layouts.admin')

@section('titre', 'Nouvel Enseignant')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Ajouter un nouvel enseignant</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('personnes.enseignants.store') }}" method="POST">
            @include('personnes.enseignants._form', ['enseignant' => null])
        </form>
    </div>
</div>
@endsection
