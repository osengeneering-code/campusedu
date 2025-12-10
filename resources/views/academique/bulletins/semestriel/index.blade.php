@extends('layouts.admin')

@section('titre', 'Bulletins Semestriels')

@section('header')
<style>
    /* ===== HERO BANNER SPECTACULAIRE ===== */
    .bulletin-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        padding: 0;
        border-radius: 24px;
        color: white;
        position: relative;
        overflow: hidden;
        height: 350px;
        margin-bottom: 40px;
    }
    
    .hero-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1200&h=400&fit=crop') center/cover;
        opacity: 0.2;
        animation: heroZoom 20s ease-in-out infinite alternate;
    }
    
    @keyframes heroZoom {
        0% { transform: scale(1); }
        100% { transform: scale(1.1); }
    }
    
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.85) 0%, rgba(118, 75, 162, 0.85) 100%);
    }
    
    .hero-content {
        position: relative;
        z-index: 10;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 60px 50px;
    }
    
    .hero-title {
        font-size: 3.5rem;
        font-weight: 900;
        margin-bottom: 16px;
        text-shadow: 0 4px 20px rgba(0,0,0,0.3);
        animation: titleSlideIn 1s ease-out;
        letter-spacing: -1px;
    }
    
    @keyframes titleSlideIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .hero-subtitle {
        font-size: 1.3rem;
        opacity: 0.95;
        animation: subtitleSlideIn 1s ease-out 0.2s both;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    
    @keyframes subtitleSlideIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 0.95;
            transform: translateY(0);
        }
    }
    
    .hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        pointer-events: none;
    }
    
    .particle {
        position: absolute;
        background: white;
        border-radius: 50%;
        opacity: 0.3;
        animation: float 15s infinite ease-in-out;
    }
    
    .particle:nth-child(1) {
        width: 80px;
        height: 80px;
        top: 10%;
        left: 10%;
        animation-delay: 0s;
        animation-duration: 20s;
    }
    
    .particle:nth-child(2) {
        width: 120px;
        height: 120px;
        top: 60%;
        right: 15%;
        animation-delay: 2s;
        animation-duration: 18s;
    }
    
    .particle:nth-child(3) {
        width: 60px;
        height: 60px;
        bottom: 20%;
        left: 30%;
        animation-delay: 4s;
        animation-duration: 22s;
    }
    
    .particle:nth-child(4) {
        width: 100px;
        height: 100px;
        top: 30%;
        right: 30%;
        animation-delay: 1s;
        animation-duration: 19s;
    }
    
    @keyframes float {
        0%, 100% {
            transform: translate(0, 0) rotate(0deg);
            opacity: 0.3;
        }
        33% {
            transform: translate(30px, -30px) rotate(120deg);
            opacity: 0.5;
        }
        66% {
            transform: translate(-20px, 20px) rotate(240deg);
            opacity: 0.3;
        }
    }

    .hero-icon {
        font-size: 5rem;
        position: absolute;
        right: 80px;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0.15;
        animation: iconPulse 3s ease-in-out infinite;
    }
    
    @keyframes iconPulse {
        0%, 100% {
            transform: translateY(-50%) scale(1);
        }
        50% {
            transform: translateY(-50%) scale(1.1);
        }
    }

    /* ===== FILTRES DESIGN ===== */
    .filter-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: none;
        overflow: hidden;
        margin-bottom: 40px;
        animation: cardSlideUp 0.6s ease-out;
    }
    
    @keyframes cardSlideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .filter-card-header {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8ecff 100%);
        border-bottom: 3px solid #667eea;
        padding: 25px 30px;
    }
    
    .filter-card-header h5 {
        margin: 0;
        font-weight: 800;
        color: #667eea;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .filter-card-body {
        padding: 35px 30px;
    }
    
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 10px;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 0.95rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        transform: translateY(-2px);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px 32px;
        border-radius: 12px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
    }

    /* ===== CARTES BULLETINS ===== */
    .bulletins-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
        margin-top: 30px;
    }
    
    .bulletin-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent;
        animation: cardAppear 0.6s ease-out both;
        position: relative;
    }
    
    .bulletin-card:nth-child(1) { animation-delay: 0.1s; }
    .bulletin-card:nth-child(2) { animation-delay: 0.2s; }
    .bulletin-card:nth-child(3) { animation-delay: 0.3s; }
    .bulletin-card:nth-child(4) { animation-delay: 0.4s; }
    .bulletin-card:nth-child(5) { animation-delay: 0.5s; }
    .bulletin-card:nth-child(6) { animation-delay: 0.6s; }
    
    @keyframes cardAppear {
        from {
            opacity: 0;
            transform: translateY(40px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    .bulletin-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.25);
        border-color: #667eea;
    }
    
    .bulletin-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        background-size: 200% 100%;
        animation: gradientShift 3s linear infinite;
    }
    
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        100% { background-position: 200% 50%; }
    }
    
    .bulletin-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 30px 25px;
        position: relative;
        overflow: hidden;
    }
    
    .bulletin-card-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: shimmer 4s linear infinite;
    }
    
    @keyframes shimmer {
        0% { transform: translate(-50%, -50%); }
        100% { transform: translate(50%, 50%); }
    }
    
    .student-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 4px solid white;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        margin: 0 auto 15px;
        display: block;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        font-weight: bold;
        position: relative;
        z-index: 2;
        animation: avatarPop 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) both;
    }
    
    @keyframes avatarPop {
        0% {
            transform: scale(0) rotate(-180deg);
        }
        100% {
            transform: scale(1) rotate(0deg);
        }
    }
    
    .student-name {
        color: white;
        font-size: 1.4rem;
        font-weight: 800;
        margin: 0;
        text-align: center;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        position: relative;
        z-index: 2;
    }
    
    .student-matricule {
        color: rgba(255,255,255,0.9);
        font-size: 0.9rem;
        text-align: center;
        margin-top: 5px;
        font-weight: 500;
        position: relative;
        z-index: 2;
    }
    
    .bulletin-card-body {
        padding: 25px;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        margin-bottom: 10px;
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
        border-radius: 12px;
        border-left: 4px solid #667eea;
        transition: all 0.3s ease;
    }
    
    .info-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    }
    
    .info-icon {
        font-size: 1.5rem;
        margin-right: 12px;
        color: #667eea;
        min-width: 30px;
        text-align: center;
    }
    
    .info-content {
        flex: 1;
    }
    
    .info-label {
        font-size: 0.75rem;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }
    
    .info-value {
        font-size: 1rem;
        color: #2c3e50;
        font-weight: 600;
    }
    
    .bulletin-action {
        margin-top: 20px;
    }
    
    .btn-view-bulletin {
        width: 100%;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        padding: 14px 24px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    
    .btn-view-bulletin:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        color: white;
    }
    
    .btn-view-bulletin i {
        font-size: 1.2rem;
        transition: transform 0.3s ease;
    }
    
    .btn-view-bulletin:hover i {
        transform: translateX(5px);
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        animation: fadeIn 0.6s ease-out;
    }
    
    .empty-state-icon {
        font-size: 6rem;
        color: #e9ecef;
        margin-bottom: 30px;
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
    
    .empty-state h4 {
        color: #6c757d;
        font-weight: 700;
        margin-bottom: 15px;
    }
    
    .empty-state p {
        color: #adb5bd;
        font-size: 1.1rem;
    }

    /* ===== SECTION TITLE ===== */
    .section-title {
        font-size: 2rem;
        font-weight: 800;
        color: #2c3e50;
        margin: 40px 0 30px;
        display: flex;
        align-items: center;
        gap: 15px;
        position: relative;
        padding-left: 25px;
    }
    
    .section-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 6px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 3px;
    }
    
    .section-title-icon {
        font-size: 2.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* ===== BADGE COUNT ===== */
    .badge-count {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        animation: badgePulse 2s ease-in-out infinite;
    }
    
    @keyframes badgePulse {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-subtitle {
            font-size: 1rem;
        }
        
        .hero-icon {
            display: none;
        }
        
        .bulletins-grid {
            grid-template-columns: 1fr;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
    }

    /* ===== ANIMATIONS SUPPLÉMENTAIRES ===== */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }
</style>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    
    {{-- HERO BANNER --}}
    <div class="bulletin-hero">
        <div class="hero-background"></div>
        <div class="hero-overlay"></div>
        <div class="hero-particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
        <div class="hero-content">
            <h1 class="hero-title">📋 Bulletins Semestriels</h1>
            <p class="hero-subtitle">Consultez et gérez les bulletins de notes de vos étudiants</p>
        </div>
        <i class="bx bx-trophy hero-icon"></i>
    </div>

    {{-- FILTRES --}}
    <div class="filter-card">
        <div class="filter-card-header">
            <h5>
                <i class="bx bx-filter-alt"></i>
                Filtres de Recherche
            </h5>
        </div>
        <div class="filter-card-body">
            <form action="{{ route('bulletins.semestriel.index') }}" method="GET" id="filterForm">
                <div class="row g-4">
                    <div class="col-md-4">
                        <label for="annee_academique" class="form-label">
                            <i class="bx bx-calendar"></i>
                            Année Académique
                        </label>
                        <input type="text" 
                               name="annee_academique" 
                               id="annee_academique" 
                               class="form-control" 
                               value="{{ request('annee_academique', $anneeAcademique) }}" 
                               placeholder="Ex: 2023-2024">
                    </div>
                    
                    <div class="col-md-4">
                        <label for="departement_id" class="form-label">
                            <i class="bx bx-building"></i>
                            Département
                        </label>
                        <select name="departement_id" id="departement_id" class="form-select" data-selected="{{ request('departement_id') }}">
                            <option value="">Sélectionner un département</option>
                            @foreach($departements as $departement)
                                <option value="{{ $departement->id }}" {{ request('departement_id') == $departement->id ? 'selected' : '' }}>
                                    {{ $departement->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label for="filiere_id" class="form-label">
                            <i class="bx bx-book"></i>
                            Filière
                        </label>
                        <select name="filiere_id" id="filiere_id" class="form-select" data-selected="{{ request('filiere_id') }}">
                            <option value="">Sélectionner une filière</option>
                            @foreach($filieres as $filiere)
                                <option value="{{ $filiere->id }}" {{ request('filiere_id') == $filiere->id ? 'selected' : '' }}>
                                    {{ $filiere->libelle }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label for="parcours_id" class="form-label">
                            <i class="bx bx-git-branch"></i>
                            Parcours
                        </label>
                        <select name="parcours_id" id="parcours_id" class="form-select" data-selected="{{ request('parcours_id') }}">
                            <option value="">Sélectionner un parcours</option>
                            @foreach($parcours as $p)
                                <option value="{{ $p->id }}" {{ request('parcours_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label for="semestre_id" class="form-label">
                            <i class="bx bx-time-five"></i>
                            Semestre
                        </label>
                        <select name="semestre_id" id="semestre_id" class="form-select" data-selected="{{ request('semestre_id') }}">
                            <option value="">Sélectionner un semestre</option>
                            @foreach($semestres as $semestre)
                                <option value="{{ $semestre->id }}" {{ request('semestre_id') == $semestre->id ? 'selected' : '' }}>
                                    {{ $semestre->libelle }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bx bx-search-alt me-2"></i>
                            Rechercher
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- RÉSULTATS --}}
    @if(request('semestre_id') && request('annee_academique') && request('parcours_id'))
        <div class="section-title fade-in">
            <i class="bx bx-bar-chart-alt-2 section-title-icon"></i>
            <span>Bulletins disponibles</span>
            <span class="badge-count">
                <i class="bx bx-user"></i>
                {{ $etudiants->count() }} {{ $etudiants->count() > 1 ? 'étudiants' : 'étudiant' }}
            </span>
        </div>
        
        @if($etudiants->isNotEmpty())
            <div class="bulletins-grid">
                @foreach($etudiants as $etudiant)
                    <div class="bulletin-card">
                        <div class="bulletin-card-header">
                            <div class="student-avatar">
                                {{ strtoupper(substr($etudiant->prenom ?? 'E', 0, 1)) }}{{ strtoupper(substr($etudiant->nom ?? 'T', 0, 1)) }}
                            </div>
                            <h3 class="student-name">{{ $etudiant->nom }} {{ $etudiant->prenom }}</h3>
                            <p class="student-matricule">
                                <i class="bx bx-id-card me-1"></i>
                                {{ $etudiant->matricule }}
                            </p>
                        </div>
                        
                        <div class="bulletin-card-body">
                            <div class="info-item">
                                <i class="bx bx-calendar-check info-icon"></i>
                                <div class="info-content">
                                    <div class="info-label">Année Académique</div>
                                    <div class="info-value">{{ request('annee_academique') }}</div>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <i class="bx bx-time-five info-icon"></i>
                                <div class="info-content">
                                    <div class="info-label">Semestre</div>
                                    <div class="info-value">{{ $semestres->firstWhere('id', request('semestre_id'))->libelle ?? 'N/A' }}</div>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <i class="bx bx-git-branch info-icon"></i>
                                <div class="info-content">
                                    <div class="info-label">Parcours</div>
                                    <div class="info-value">{{ $parcours->firstWhere('id', request('parcours_id'))->nom ?? 'N/A' }}</div>
                                </div>
                            </div>
                            
                            <div class="bulletin-action">
                                <a href="{{ route('bulletins.semestriel.show', [
                                    'anneeAcademique' => request('annee_academique'),
                                    'semestre' => request('semestre_id'),
                                    'etudiant' => $etudiant->id
                                ]) }}" class="btn-view-bulletin">
                                    <i class="bx bx-file-find"></i>
                                    <span>Consulter le Bulletin</span>
                                    <i class="bx bx-right-arrow-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="bx bx-folder-open empty-state-icon"></i>
                <h4>Aucun étudiant trouvé</h4>
                <p>Aucun bulletin n'est disponible pour les critères sélectionnés.</p>
            </div>
        @endif
    @else
        <div class="empty-state">
            <i class="bx bx-search-alt empty-state-icon"></i>
            <h4>Effectuez une recherche</h4>
            <p>Veuillez sélectionner une année académique, un département, une filière, un parcours et un semestre pour afficher les bulletins.</p>
        </div>
    @endif
</div>
@endsection

@section('footer')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const departementSelect = document.getElementById('departement_id');
        const filiereSelect = document.getElementById('filiere_id');
        const parcoursSelect = document.getElementById('parcours_id');
        const semestreSelect = document.getElementById('semestre_id');

        // Fonction générique pour charger les options
        function loadOptions(selectElement, url, selectedId = null, textKey = 'libelle') {
            selectElement.innerHTML = '<option value="">Sélectionner...</option>'; // Réinitialiser
            if (!url || url.endsWith('/null')) { // Éviter les appels inutiles si l'ID est null ou url vide
                return Promise.resolve([]); // Retourner une promesse résolue avec un tableau vide
            }

            return fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Erreur HTTP: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item[textKey];
                        if (selectedId && item.id == selectedId) {
                            option.selected = true;
                        }
                        selectElement.appendChild(option);
                    });
                    return data; // Retourner les données pour les chaînes .then
                })
                .catch(error => {
                    console.error('Erreur de chargement des options:', error);
                    // Afficher un message d'erreur à l'utilisateur si nécessaire
                    return []; // Retourner un tableau vide en cas d'erreur
                });
        }

        // --- Événements de changement ---
        departementSelect.addEventListener('change', function() {
            const departementId = this.value;
            loadOptions(filiereSelect, `/api/filieres-by-departement/${departementId}`, null, 'libelle');
            parcoursSelect.innerHTML = '<option value="">Sélectionner un parcours</option>'; // Réinitialiser
            semestreSelect.innerHTML = '<option value="">Sélectionner un semestre</option>'; // Réinitialiser
        });

        filiereSelect.addEventListener('change', function() {
            const filiereId = this.value;
            loadOptions(parcoursSelect, `/api/parcours-by-filiere/${filiereId}`, null, 'nom');
            semestreSelect.innerHTML = '<option value="">Sélectionner un semestre</option>'; // Réinitialiser
        });

        parcoursSelect.addEventListener('change', function() {
            const parcoursId = this.value;
            loadOptions(semestreSelect, `/api/semestres-by-parcours/${parcoursId}`, null, 'libelle');
        });

        // --- Pré-remplissage au chargement de la page ---
        const initialDepartementId = departementSelect.dataset.selected;
        const initialFiliereId = filiereSelect.dataset.selected;
        const initialParcoursId = parcoursSelect.dataset.selected;
        const initialSemestreId = semestreSelect.dataset.selected;

        if (initialDepartementId) {
            loadOptions(filiereSelect, `/api/filieres-by-departement/${initialDepartementId}`, initialFiliereId, 'libelle')
                .then(() => {
                    if (initialFiliereId) {
                        loadOptions(parcoursSelect, `/api/parcours-by-filiere/${initialFiliereId}`, initialParcoursId, 'nom')
                            .then(() => {
                                if (initialParcoursId) {
                                    loadOptions(semestreSelect, `/api/semestres-by-parcours/${initialParcoursId}`, initialSemestreId, 'libelle');
                                }
                            });
                    }
                });
        }
    });
</script>
@endsection