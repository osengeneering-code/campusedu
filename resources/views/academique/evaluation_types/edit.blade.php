@extends('layouts.admin')

@section('titre', 'Modifier le Type d\'Évaluation')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Modifier le Type d\'Évaluation : {{ $evaluationType->name }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('academique.evaluation-types.update', $evaluationType) }}" method="POST">
            @method('PUT')
            @include('academique.evaluation_types._form')
        </form>
    </div>
</div>
@endsection
