@extends('layouts.admin')

@section('titre', 'Modifier le Module')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Modifier le module : {{ $module->libelle }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('academique.modules.update', $module) }}" method="POST">
            @method('PUT')
            @include('academique.modules._form')
        </form>
    </div>
</div>
@endsection
