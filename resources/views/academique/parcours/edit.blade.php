@extends('layouts.admin')

@section('titre', 'Modifier le Parcours')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Modifier le parcours : {{ $parcours->nom }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('academique.parcours.update', $parcours) }}" method="POST">
            @method('PUT')
            @include('academique.parcours._form')
        </form>
    </div>
</div>
@endsection
