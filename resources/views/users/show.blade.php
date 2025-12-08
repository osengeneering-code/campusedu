@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
         <div class="nav-align-top">
        <ul class="nav nav-pills flex-column flex-md-row mb-6 flex-wrap row-gap-2">
          <li class="nav-item">
            <a class="nav-link active" ><i class="icon-base bx bx-user icon-sm me-1_5"></i>Mon compte</a>
          </li>
          <li class="nav-item">
            <a class="nav-link  active bg-warning" href="{{ route('users.edit', $user->id) }}"><i class="icon-base bx bx-link icon-sm me-1_5"></i>Mettre mon compte a jour!</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active bg-info" data-bs-toggle="modal" data-bs-target="#changePasswordModal"><i class="icon-base bx bx-lock-alt icon-sm me-1_5 " ></i>Mettre a jour mon mot de passe</a>
          </li>
          <li class="nav-item">
            <a class="nav-link  active bg-secondary"  data-bs-toggle="modal" data-bs-target="#permissionsModal"><i class="icon-base bx bx-bell icon-sm me-1_5"></i>Mes habilitations</a>
          </li>
        </ul>
      </div>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Profil de l'utilisateur : {{ $user->prenom }} {{ $user->nom }}</h5>
                @role('admin')
                    <a href="{{ route('users.index') }}" class="btn btn-primary">Retour à la liste</a>
                @endrole
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img src=" {{ Auth::user()->photo ? asset(Auth::user()->photo) : asset('images/logo.png') }}" alt="Photo de profil" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        <h5 class="mb-0">{{ $user->prenom }} {{ $user->nom }}</h5>
                        <p class="text-muted">{{ $user->email }}</p>
                    </div>
                    <div class="col-md-8">
                        <h4 class="mb-4">Détails de l'utilisateur</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Nom :</strong> {{ $user->nom }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Prénom :</strong> {{ $user->prenom }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Email :</strong> {{ $user->email }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Téléphone :</strong> {{ $user->telephone }}
                            </div>
                            <div class="col-md-12 mb-3">
                                <strong>Adresse :</strong> {{ $user->adresse ?? 'N/A' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Statut :</strong>
                                <span class="badge {{ $user->statut === 'actif' ? 'bg-label-success' : 'bg-label-danger' }} me-1">
                                    {{ $user->statut }}
                                </span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Entreprise :</strong> {{ $user->entreprise->nom ?? 'N/A' }}
                            </div>
                            <div class="col-md-12 mb-3">
                                <strong>Rôles :</strong>
                                @foreach ($user->roles as $role)
                                    <span class="badge bg-label-info me-1">{{ $role->name }}</span>
                                @endforeach
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Membre depuis :</strong> {{ $user->created_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Dernière mise à jour :</strong> {{ $user->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        <div class="mt-4 d-flex flex-wrap gap-2 bg-dark">
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Changer le mot de passe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.updatePassword', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="new_password" name="password" placeholder="Entrez le nouveau mot de passe">
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="password_confirmation" placeholder="Confirmez le nouveau mot de passe">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Permissions Modal -->
<div class="modal fade" id="permissionsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Permissions de l'utilisateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Permissions directes :</strong></p>
                @forelse ($user->getDirectPermissions() as $permission)
                    <span class="badge bg-label-primary me-1">{{ $permission->name }}</span>
                @empty
                    <p>Aucune permission directe accordée.</p>
                @endforelse

                <p class="mt-3"><strong>Permissions via les rôles :</strong></p>
                @forelse ($user->roles as $role)
                    <h6>Rôle : {{ $role->name }}</h6>
                    @forelse ($role->permissions as $permission)
                        <span class="badge bg-label-info me-1 mr-3 mb-3">{{ $permission->name }}</span>
                    @empty
                        <p>Aucune permission pour ce rôle.</p>
                    @endforelse
                @empty
                    <p>Aucun rôle attribué.</p>
                @endforelse

                <p class="mt-3"><strong>Toutes les permissions effectives :</strong></p>
                @forelse ($user->getAllPermissions() as $permission)
                    <span class="badge bg-label-success me-1 mr-3 mb-3">{{ $permission->name }}</span>
                @empty
                    <p>Aucune permission effective.</p>
                @endforelse
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

@endsection