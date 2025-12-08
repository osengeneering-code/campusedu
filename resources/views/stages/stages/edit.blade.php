@extends('layouts.admin')

@section('titre', 'Modifier le Stage')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Modifier le stage de : {{ $stage->inscriptionAdmin->etudiant->nom ?? '' }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('stages.stages.update', $stage) }}" method="POST">
            @method('PUT')
            @include('stages.stages._form')
        </form>
    </div>
</div>
@endsection
