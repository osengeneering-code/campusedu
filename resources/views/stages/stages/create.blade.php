@extends('layouts.admin')

@section('titre', 'Nouveau Stage')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Affecter un nouveau stage</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('stages.stages.store') }}" method="POST">
            @include('stages.stages._form')
        </form>
    </div>
</div>
@endsection
