@extends('layouts.admin')

@section('titre', 'Nouvelle Inscription Administrative')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Enregistrer une Nouvelle Inscription Administrative</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('inscriptions.inscription-admins.store') }}" method="POST">
            @csrf
            @include('inscriptions.inscription-admins._form', ['inscriptionAdmin' => new App\Models\InscriptionAdmin()])
            <button type="submit" class="btn btn-primary mt-3">Enregistrer l'Inscription</button>
            <a href="{{ route('inscriptions.inscription-admins.index') }}" class="btn btn-secondary mt-3">Annuler</a>
        </form>
    </div>
</div>
@endsection