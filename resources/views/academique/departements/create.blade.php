@extends('layouts.admin')

@section('titre', 'Nouveau Département')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Ajouter un nouveau département</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('academique.departements.store') }}" method="POST">
            @include('academique.departements._form')
        </form>
    </div>
</div>
@endsection
