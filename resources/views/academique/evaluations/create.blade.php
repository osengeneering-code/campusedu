@extends('layouts.admin')

@section('titre', 'Créer une Évaluation')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Créer une nouvelle Évaluation</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('gestion-cours.evaluations.store') }}" method="POST">
            @include('academique.evaluations._form')
        </form>
    </div>
</div>
@endsection
