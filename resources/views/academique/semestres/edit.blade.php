@extends('layouts.admin')

@section('titre', 'Modifier le Semestre')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Modifier le semestre : {{ $semestre->libelle }} ({{ $semestre->niveau }})</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('academique.semestres.update', $semestre) }}" method="POST">
            @method('PUT')
            @include('academique.semestres._form')
        </form>
    </div>
</div>
@endsection
