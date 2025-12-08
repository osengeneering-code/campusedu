@extends('layouts.admin')

@section('titre', 'Modifier l\'Évaluation')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Modifier l\'Évaluation : {{ $evaluation->libelle }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('gestion-cours.evaluations.update', $evaluation) }}" method="POST">
            @method('PUT')
            @include('academique.evaluations._form')
        </form>
    </div>
</div>
@endsection

