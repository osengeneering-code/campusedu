@extends('layouts.admin')

@section('titre', 'Enregistrer un Paiement')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Enregistrer un nouveau paiement</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('paiements.store') }}" method="POST">
            @include('financier.paiements._form', ['paiement' => null])
        </form>
    </div>
</div>
@endsection
