@extends('layouts.admin')

@section('titre', 'Modifier l\'UE')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Modifier l\'UE : {{ $ue->libelle }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('academique.ues.update', $ue) }}" method="POST">
            @method('PUT')
            @include('academique.ues._form')
        </form>
    </div>
</div>
@endsection

