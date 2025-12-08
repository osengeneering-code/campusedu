@extends('layouts.admin')

@section('titre', 'Modifier le Paiement')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Modifier le paiement : {{ $paiement->reference_paiement }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('paiements.update', $paiement) }}" method="POST">
            @method('PUT')
            @include('financier.paiements._form')
        </form>
    </div>
</div>
@endsection
