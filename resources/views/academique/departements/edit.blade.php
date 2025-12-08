@extends('layouts.admin')

@section('titre', 'Modifier le Département')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Modifier le département : {{ $departement->nom }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('academique.departements.update', $departement) }}" method="POST">
            @method('PUT')
            @include('academique.departements._form')
        </form>
    </div>
</div>
@endsection
