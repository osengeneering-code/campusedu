@extends('layouts.admin')

@section('content')
 <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- Basic Bootstrap Table -->
                       
              <div class="row g-6 mb-6">
                  <div class="col-sm-6 col-xl-3">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                          <div class="content-left">
                            <span class="text-heading">Total Utilisateurs</span>
                            <div class="d-flex align-items-center my-1">
                              <h4 class="mb-0 me-2">{{ $totalUsers }}</h4>
                            </div>
                          </div>
                          <div class="avatar">
                            <span class="avatar-initial rounded bg-label-primary">
                              <i class="icon-base bx bx-group icon-lg"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-xl-3">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                          <div class="content-left">
                            <span class="text-heading">Utilisateurs Actifs</span>
                            <div class="d-flex align-items-center my-1">
                              <h4 class="mb-0 me-2">{{ $activeUsers }}</h4>
                            </div>
                          </div>
                          <div class="avatar">
                            <span class="avatar-initial rounded bg-label-success">
                              <i class="icon-base bx bx-user-check icon-lg"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-xl-3">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                          <div class="content-left">
                            <span class="text-heading">Utilisateurs Suspendus</span>
                            <div class="d-flex align-items-center my-1">
                              <h4 class="mb-0 me-2">{{ $blockedUsers }}</h4>
                            </div>
                          </div>
                          <div class="avatar">
                            <span class="avatar-initial rounded bg-label-warning">
                              <i class="icon-base bx bx-user-voice icon-lg"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-xl-3">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                          <div class="content-left">
                            <span class="text-heading">Total Sessions</span>
                            <div class="d-flex align-items-center my-1">
                              <h4 class="mb-0 me-2">{{ $totalUsers }}</h4>
                            </div>
                          </div>
                          <div class="avatar">
                            <span class="avatar-initial rounded bg-label-info">
                              <i class="icon-base bx bx-laptop icon-lg"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal">
                            Ajouter un utilisateur
                        </button>
                        <h5 class="mb-0">Gestion des Utilisateurs</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.index') }}" method="GET" class="mb-4">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label for="filter_role" class="form-label">Filtrer par Rôle</label>
                                    <select name="filter_role" id="filter_role" class="form-select">
                                        <option value="">Tous les rôles</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" {{ request('filter_role') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="filter_statut" class="form-label">Filtrer par Statut</label>
                                    <select name="filter_statut" id="filter_statut" class="form-select">
                                        <option value="">Tous les statuts</option>
                                        @foreach ($userStatuses as $status)
                                            <option value="{{ $status->value }}" {{ request('filter_statut') == $status->value ? 'selected' : '' }}>{{ $status->value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="filter_entreprise" class="form-label">Filtrer par Entreprise</label>
                                    <select name="filter_entreprise" id="filter_entreprise" class="form-select">
                                        <option value="">Toutes les entreprises</option>
                                        @foreach ($entreprises as $entreprise)
                                            <option value="{{ $entreprise->id }}" {{ request('filter_entreprise') == $entreprise->id ? 'selected' : '' }}>{{ $entreprise->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Appliquer les filtres</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-label-secondary">Réinitialiser</a>
                                </div>
                            </div>
                        </form>
                    </div>
                          <!-- Large Modal -->
                          <div class="modal fade" id="largeModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel3">Créer un nouvel utilisateur</h5>
                                  <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <form action="{{ route('users.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="entreprise_id" class="form-label">Entreprise</label>
                                                <select name="entreprise_id" id="entreprise_id" class="form-select @error('entreprise_id') is-invalid @enderror">
                                                    <option value="">Sélectionner une entreprise</option>
                                                    @foreach ($entreprises as $entreprise)
                                                        <option value="{{ $entreprise->id }}" {{ old('entreprise_id') == $entreprise->id ? 'selected' : '' }}>{{ $entreprise->nom }}</option>
                                                    @endforeach
                                                </select>
                                                @error('entreprise_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="nom" class="form-label">Nom</label>
                                                <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" placeholder="Nom de l'utilisateur">
                                                @error('nom')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="prenom" class="form-label">Prénom</label>
                                                <input type="text" name="prenom" id="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" placeholder="Prénom de l'utilisateur">
                                                @error('prenom')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email de l'utilisateur">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="password" class="form-label">Mot de passe</label>
                                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mot de passe">
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="telephone" class="form-label">Téléphone</label>
                                                <input type="text" name="telephone" id="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}" placeholder="Numéro de téléphone">
                                                @error('telephone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <label for="adresse" class="form-label">Adresse</label>
                                                <textarea name="adresse" id="adresse" class="form-control @error('adresse') is-invalid @enderror" rows="3" placeholder="Adresse de l'utilisateur">{{ old('adresse') }}</textarea>
                                                @error('adresse')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="statut" class="form-label">Statut</label>
                                                <select name="statut" id="statut" class="form-select @error('statut') is-invalid @enderror">
                                                    <option value="">Sélectionner un statut</option>
                                                    @foreach ($userStatuses as $status)
                                                        <option value="{{ $status->value }}" {{ old('statut') == $status->value ? 'selected' : '' }}>{{ $status->value }}</option>
                                                    @endforeach
                                                </select>
                                                @error('statut')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="roles" class="form-label">Rôles</label>
                                                <select name="roles[]" id="roles" class="form-select @error('roles') is-invalid @enderror" multiple>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->name }}" {{ in_array($role->name, old('roles', [])) ? 'selected' : '' }}>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('roles')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Fermer</button>
                                        <button type="submit" class="btn btn-primary">Créer l'utilisateur</button>
                                    </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        <div class="table-responsive text-nowrap">
                          <table class="table">
                            <thead>
                              <tr>
                                <th>Nom Complet</th>
                                <th>Email</th>
                                <th>Rôles</th>
                                <th>Statut</th>
                                <th>Actions</th>
                              </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <img src="{{ $user->profile_photo_url ? asset($user->profile_photo_url) : asset('images/logo.png') }}" alt="Avatar" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                            <span>{{ $user->nom }} {{ $user->prenom }}</span>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                                <span class="badge bg-label-info me-1">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <span class="badge {{ $user->statut === 'actif' ? 'bg-label-success' : 'bg-label-danger' }} me-1">
                                                <i class="icon-base bx {{ $user->statut === 'actif' ? 'bx-check-circle' : 'bx-lock-alt' }} me-1"></i>
                                                {{ $user->statut }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-inline-flex">
                                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-icon item-edit"><i class="bx bx-show bx-md"></i></a>
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-icon item-edit"><i class="bx bx-edit bx-md"></i></a>
                                                <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir {{ $user->statut === 'actif' ? 'suspendre' : 'réactiver' }} cet utilisateur ?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-icon item-edit"><i class="bx {{ $user->statut === 'actif' ? 'bx-lock' : 'bx-lock-open' }} bx-md"></i></button>
                                                </form>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-icon item-edit text-danger"><i class="bx bx-trash bx-md"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                          </table>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $users->links() }}
                        </div>
                      </div>
                      <!--/ Basic Bootstrap Table -->
                  </div>
        @endsection
