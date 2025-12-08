@extends('layouts.admin')

@section('titre', 'Nouveau Module')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Ajouter un nouveau module</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('academique.modules.store') }}" method="POST">
            @include('academique.modules._form')
        </form>
    </div>
</div>
@endsection
