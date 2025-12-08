@extends('layouts.admin')

@section('titre', 'Nouvelle Conversation')

@section('header')
<style>
    .user-card {
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid transparent;
    }
    .user-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        border-color: #0d6efd;
    }
    .user-card.selected {
        border-color: #0d6efd;
        background-color: #e7f3ff;
    }
    .user-card .avatar {
        width: 50px;
        height: 50px;
    }
    .search-box {
        position: relative;
    }
    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }
    .search-box input {
        padding-left: 45px;
    }
    .badge-online {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        background-color: #28a745;
        border: 2px solid white;
        border-radius: 50%;
    }
    .conversation-type-card {
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid #dee2e6;
        height: 100%;
    }
    .conversation-type-card:hover {
        border-color: #0d6efd;
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .conversation-type-card.selected {
        border-color: #0d6efd;
        background-color: #e7f3ff;
    }
    .conversation-type-card .icon-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin: 0 auto 1rem;
    }
    .selected-users-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        padding: 12px;
        background-color: #f8f9fa;
        border-radius: 8px;
        min-height: 50px;
    }
    .selected-user-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        background-color: white;
        border: 1px solid #dee2e6;
        border-radius: 20px;
        font-size: 0.875rem;
    }
    .selected-user-badge img {
        width: 24px;
        height: 24px;
        border-radius: 50%;
    }
    .selected-user-badge .remove {
        cursor: pointer;
        color: #dc3545;
        font-size: 1.2rem;
        line-height: 1;
        margin-left: 4px;
    }
    .selected-user-badge .remove:hover {
        color: #bb2d3b;
    }
    .step-indicator {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2rem;
        position: relative;
    }
    .step-indicator::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #dee2e6;
        z-index: -1;
    }
    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        position: relative;
        background-color: white;
    }
    .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #dee2e6;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-bottom: 8px;
    }
    .step-item.active .step-number {
        background-color: #0d6efd;
    }
    .step-item.completed .step-number {
        background-color: #28a745;
    }
    .no-results {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1 fw-bold">Nouvelle Conversation</h4>
                <p class="text-muted mb-0">Démarrez une conversation directe ou créez un groupe</p>
            </div>
            <a href="{{ route('conversations.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back me-1"></i> Retour
            </a>
        </div>

        <form action="{{ route('conversations.store') }}" method="POST" id="conversationForm">
            @csrf
            
            <!-- Indicateur d'étapes -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="step-indicator">
                        <div class="step-item active" id="step1Indicator">
                            <div class="step-number">1</div>
                            <small class="text-muted">Type</small>
                        </div>
                        <div class="step-item" id="step2Indicator">
                            <div class="step-number">2</div>
                            <small class="text-muted">Participants</small>
                        </div>
                        <div class="step-item" id="step3Indicator">
                            <div class="step-number">3</div>
                            <small class="text-muted">Détails</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Étape 1: Choisir le type -->
            <div class="card shadow-sm mb-4" id="step1">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Étape 1 : Choisir le type de conversation</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="conversation-type-card card h-100 text-center p-4" data-type="direct">
                                <div class="icon-wrapper bg-primary bg-opacity-10 text-primary">
                                    <i class="bx bx-user"></i>
                                </div>
                                <h5 class="fw-bold">Discussion Directe</h5>
                                <p class="text-muted mb-0">Conversation privée avec un seul utilisateur</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="conversation-type-card card h-100 text-center p-4" data-type="group">
                                <div class="icon-wrapper bg-success bg-opacity-10 text-success">
                                    <i class="bx bx-group"></i>
                                </div>
                                <h5 class="fw-bold">Groupe</h5>
                                <p class="text-muted mb-0">Conversation avec plusieurs participants</p>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="type" id="conversationType" required>
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-primary" id="nextToStep2" disabled>
                            Suivant <i class="bx bx-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Étape 2: Sélectionner les participants -->
            <div class="card shadow-sm mb-4 d-none" id="step2">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Étape 2 : Sélectionner les participants</h5>
                </div>
                <div class="card-body">
                    <!-- Barre de recherche -->
                    <div class="search-box mb-4">
                        <i class="bx bx-search"></i>
                        <input type="text" class="form-control form-control-lg" id="searchUsers" 
                               placeholder="Rechercher par nom ou email...">
                    </div>

                    <!-- Utilisateurs sélectionnés -->
                    <div class="mb-4" id="selectedUsersWrapper" style="display: none;">
                        <label class="form-label fw-bold">Participants sélectionnés :</label>
                        <div class="selected-users-container" id="selectedUsersContainer">
                            <span class="text-muted">Aucun participant sélectionné</span>
                        </div>
                    </div>

                    <!-- Liste des utilisateurs -->
                    <div class="row g-3" id="usersList">
                        @forelse($users ?? [] as $user)
                            <div class="col-md-6 col-lg-4 user-item" data-user-id="{{ $user->id }}" 
                                 data-user-name="{{ strtolower($user->name ?? '') }}" 
                                 data-user-email="{{ strtolower($user->email ?? '') }}">
                                <div class="user-card card h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="position-relative me-3">
                                            <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') }}" 
                                                 class="avatar rounded-circle" alt="Avatar">
                                            @if($user->is_online ?? false)
                                                <span class="badge-online"></span>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 min-width-0">
                                            <h6 class="mb-0 fw-bold text-truncate">{{ $user->name ?? 'Utilisateur' }}</h6>
                                            <small class="text-muted text-truncate d-block">{{ $user->email ?? '' }}</small>
                                            @if($user->is_online ?? false)
                                                <span class="badge badge-sm bg-success-subtle text-success mt-1">En ligne</span>
                                            @endif
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input user-checkbox" type="checkbox" 
                                                   name="users[]" value="{{ $user->id }}" 
                                                   id="user{{ $user->id }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="no-results">
                                    <i class="bx bx-user-x" style="font-size: 3rem;"></i>
                                    <p class="mt-2">Aucun utilisateur disponible</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Message si aucun résultat -->
                    <div class="no-results d-none" id="noResults">
                        <i class="bx bx-search-alt" style="font-size: 3rem;"></i>
                        <p class="mt-2">Aucun utilisateur trouvé</p>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary" id="backToStep1">
                            <i class="bx bx-arrow-left me-1"></i> Précédent
                        </button>
                        <button type="button" class="btn btn-primary" id="nextToStep3" disabled>
                            Suivant <i class="bx bx-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Étape 3: Détails (pour les groupes) -->
            <div class="card shadow-sm mb-4 d-none" id="step3">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Étape 3 : Informations du groupe</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="mb-4">
                                <label for="groupName" class="form-label fw-bold">
                                    Nom du groupe <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-lg" id="groupName" 
                                       name="name" placeholder="Ex: Équipe Marketing">
                                <small class="text-muted">Choisissez un nom descriptif pour votre groupe</small>
                            </div>

                            <div class="mb-4">
                                <label for="groupDescription" class="form-label fw-bold">
                                    Description <small class="text-muted">(optionnelle)</small>
                                </label>
                                <textarea class="form-control" id="groupDescription" name="description" 
                                          rows="3" placeholder="Décrivez l'objectif de ce groupe..."></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Récapitulatif</label>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="bx bx-group text-primary fs-4 me-2"></i>
                                            <div>
                                                <small class="text-muted d-block">Type de conversation</small>
                                                <strong id="summaryType">Groupe</strong>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bx bx-user text-primary fs-4 me-2"></i>
                                            <div>
                                                <small class="text-muted d-block">Nombre de participants</small>
                                                <strong id="summaryCount">0 participant(s)</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" id="backToStep2">
                                    <i class="bx bx-arrow-left me-1"></i> Précédent
                                </button>
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bx bx-check me-1"></i> Créer la conversation
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bouton de soumission pour discussion directe -->
            <div id="directSubmitBtn" class="d-none">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bx bx-message-add me-2"></i> Démarrer la conversation
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('footer')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedType = '';
    let selectedUsers = [];

    // Éléments
    const typeCards = document.querySelectorAll('.conversation-type-card');
    const userCards = document.querySelectorAll('.user-card');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    const searchInput = document.getElementById('searchUsers');
    const selectedUsersContainer = document.getElementById('selectedUsersContainer');
    const selectedUsersWrapper = document.getElementById('selectedUsersWrapper');
    const conversationForm = document.getElementById('conversationForm');
    
    // Étapes
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const step3 = document.getElementById('step3');
    const directSubmitBtn = document.getElementById('directSubmitBtn');
    
    // Indicateurs
    const step1Indicator = document.getElementById('step1Indicator');
    const step2Indicator = document.getElementById('step2Indicator');
    const step3Indicator = document.getElementById('step3Indicator');
    
    // Boutons
    const nextToStep2 = document.getElementById('nextToStep2');
    const nextToStep3 = document.getElementById('nextToStep3');
    const backToStep1 = document.getElementById('backToStep1');
    const backToStep2 = document.getElementById('backToStep2');

    // Étape 1: Sélection du type
    typeCards.forEach(card => {
        card.addEventListener('click', function() {
            typeCards.forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            selectedType = this.getAttribute('data-type');
            document.getElementById('conversationType').value = selectedType;
            nextToStep2.disabled = false;
        });
    });

    // Navigation: Étape 1 -> 2
    nextToStep2?.addEventListener('click', function() {
        step1.classList.add('d-none');
        step2.classList.remove('d-none');
        step1Indicator.classList.add('completed');
        step2Indicator.classList.add('active');
        
        // Pour discussion directe, limiter à 1 sélection
        if (selectedType === 'direct') {
            updateCheckboxBehavior();
        }
    });

    // Navigation: Étape 2 -> 1
    backToStep1?.addEventListener('click', function() {
        step2.classList.add('d-none');
        step1.classList.remove('d-none');
        step2Indicator.classList.remove('active');
        step1Indicator.classList.remove('completed');
    });

    // Navigation: Étape 2 -> 3
    nextToStep3?.addEventListener('click', function() {
        if (selectedType === 'group') {
            step2.classList.add('d-none');
            step3.classList.remove('d-none');
            step2Indicator.classList.add('completed');
            step3Indicator.classList.add('active');
            updateSummary();
        } else {
            // Pour discussion directe, soumettre directement
            step2.classList.add('d-none');
            directSubmitBtn.classList.remove('d-none');
        }
    });

    // Navigation: Étape 3 -> 2
    backToStep2?.addEventListener('click', function() {
        step3.classList.add('d-none');
        step2.classList.remove('d-none');
        step3Indicator.classList.remove('active');
        step2Indicator.classList.remove('completed');
    });

    // Gestion des sélections d'utilisateurs
    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const userId = this.value;
            const userName = this.closest('.user-item').querySelector('h6').textContent;
            const userAvatar = this.closest('.user-item').querySelector('img').src;
            
            if (this.checked) {
                // Pour discussion directe, décocher les autres
                if (selectedType === 'direct') {
                    userCheckboxes.forEach(cb => {
                        if (cb !== this) {
                            cb.checked = false;
                            cb.closest('.user-card').classList.remove('selected');
                        }
                    });
                    selectedUsers = [{id: userId, name: userName, avatar: userAvatar}];
                } else {
                    selectedUsers.push({id: userId, name: userName, avatar: userAvatar});
                }
                this.closest('.user-card').classList.add('selected');
            } else {
                selectedUsers = selectedUsers.filter(u => u.id !== userId);
                this.closest('.user-card').classList.remove('selected');
            }
            
            updateSelectedUsers();
            updateNextButton();
        });
    });

    // Clic sur la carte utilisateur
    userCards.forEach(card => {
        card.addEventListener('click', function(e) {
            if (!e.target.classList.contains('form-check-input')) {
                const checkbox = this.querySelector('.user-checkbox');
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change'));
            }
        });
    });

    // Mise à jour de l'affichage des utilisateurs sélectionnés
    function updateSelectedUsers() {
        if (selectedUsers.length === 0) {
            selectedUsersWrapper.style.display = 'none';
            selectedUsersContainer.innerHTML = '<span class="text-muted">Aucun participant sélectionné</span>';
        } else {
            selectedUsersWrapper.style.display = 'block';
            selectedUsersContainer.innerHTML = selectedUsers.map(user => `
                <div class="selected-user-badge">
                    <img src="${user.avatar}" alt="Avatar">
                    <span>${user.name}</span>
                    <span class="remove" data-user-id="${user.id}">×</span>
                </div>
            `).join('');
            
            // Ajouter les événements de suppression
            document.querySelectorAll('.selected-user-badge .remove').forEach(btn => {
                btn.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    const checkbox = document.querySelector(`input[value="${userId}"]`);
                    if (checkbox) {
                        checkbox.checked = false;
                        checkbox.dispatchEvent(new Event('change'));
                    }
                });
            });
        }
    }

    // Mise à jour du bouton suivant
    function updateNextButton() {
        if (selectedType === 'direct') {
            nextToStep3.disabled = selectedUsers.length !== 1;
        } else {
            nextToStep3.disabled = selectedUsers.length < 2;
        }
    }

    // Comportement des checkboxes selon le type
    function updateCheckboxBehavior() {
        // Réinitialiser toutes les sélections
        userCheckboxes.forEach(cb => {
            cb.checked = false;
            cb.closest('.user-card').classList.remove('selected');
        });
        selectedUsers = [];
        updateSelectedUsers();
        updateNextButton();
    }

    // Recherche d'utilisateurs
    searchInput?.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const userItems = document.querySelectorAll('.user-item');
        let visibleCount = 0;
        
        userItems.forEach(item => {
            const name = item.getAttribute('data-user-name');
            const email = item.getAttribute('data-user-email');
            
            if (name.includes(searchTerm) || email.includes(searchTerm)) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        // Afficher/masquer le message "aucun résultat"
        const noResults = document.getElementById('noResults');
        const usersList = document.getElementById('usersList');
        if (visibleCount === 0) {
            usersList.classList.add('d-none');
            noResults.classList.remove('d-none');
        } else {
            usersList.classList.remove('d-none');
            noResults.classList.add('d-none');
        }
    });

    // Mise à jour du récapitulatif
    function updateSummary() {
        const summaryType = document.getElementById('summaryType');
        const summaryCount = document.getElementById('summaryCount');
        
        if (summaryType) {
            summaryType.textContent = selectedType === 'group' ? 'Groupe' : 'Discussion directe';
        }
        
        if (summaryCount) {
            summaryCount.textContent = `${selectedUsers.length} participant(s)`;
        }
    }

    // Validation du formulaire
    conversationForm?.addEventListener('submit', function(e) {
        if (selectedType === 'group') {
            const groupName = document.getElementById('groupName').value.trim();
            if (!groupName) {
                e.preventDefault();
                alert('Veuillez saisir un nom pour le groupe');
                return false;
            }
        }
        
        if (selectedUsers.length === 0) {
            e.preventDefault();
            alert('Veuillez sélectionner au moins un participant');
            return false;
        }
    });
});
</script>
@endsection