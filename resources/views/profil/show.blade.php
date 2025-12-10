@extends('layouts.admin')

@section('titre', 'Mon Profil')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Mon Profil</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Détails du Profil</h5>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ $user->profile_photo_url }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">Prénom</label>
                            <input class="form-control" type="text" id="firstName" name="firstName" value="{{ $user->prenom }}" readonly />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Nom</label>
                            <input class="form-control" type="text" name="lastName" id="lastName" value="{{ $user->nom }}" readonly />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input class="form-control" type="text" id="email" name="email" value="{{ $user->email }}" readonly />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="organization" class="form-label">Téléphone</label>
                            <input type="text" class="form-control" id="organization" name="organization" value="{{ $user->telephone }}" readonly />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Rôles</label>
                            <p class="form-control-static">
                                @foreach($user->roles as $role)
                                    <span class="badge bg-label-primary me-1">{{ $role->name }}</span>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>
</div>
@endsection
