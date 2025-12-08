@extends('layouts.admin')

@section('titre', 'Mes Étudiants Stagiaires')

@section('content')
<style>
    .page-header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        padding: 60px 40px;
        border-radius: 24px;
        margin-bottom: 40px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(30, 60, 114, 0.3);
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }
    
    .page-header h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 10px;
        position: relative;
        z-index: 2;
    }
    
    .page-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        position: relative;
        z-index: 2;
    }
    
    .students-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }
    
    .student-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid #e8ecf3;
    }
    
    .student-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 50px rgba(30, 60, 114, 0.2);
        border-color: #2a5298;
    }
    
    .card-banner {
        height: 120px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
    }
    
    .card-banner-1 { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .card-banner-2 { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .card-banner-3 { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .card-banner-4 { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
    .card-banner-5 { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
    
    .card-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 700;
        color: #2a5298;
        position: absolute;
        bottom: -50px;
        left: 30px;
        border: 5px solid white;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .card-body {
        padding: 60px 30px 30px 30px;
    }
    
    .student-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 5px;
    }
    
    .student-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 20px;
    }
    
    .badge-en-cours {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .badge-valide {
        background: #d1fae5;
        color: #065f46;
    }
    
    .badge-en-attente {
        background: #fef3c7;
        color: #92400e;
    }
    
    .info-section {
        background: #f8fafc;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 20px;
    }
    
    .info-row {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
    }
    
    .info-row:last-child {
        margin-bottom: 0;
    }
    
    .info-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .info-content {
        flex: 1;
    }
    
    .info-label {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    
    .info-text {
        font-size: 1rem;
        color: #1e293b;
        font-weight: 600;
    }
    
    .card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    
    .action-btn {
        padding: 12px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        border: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        cursor: pointer;
    }
    
    .btn-primary-action {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        grid-column: 1 / -1;
    }
    
    .btn-primary-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(30, 60, 114, 0.4);
        color: white;
    }
    
    .btn-secondary-action {
        background: #f1f5f9;
        color: #475569;
    }
    
    .btn-secondary-action:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
        color: #334155;
    }
    
    .btn-chat {
        background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
        color: white;
    }
    
    .btn-chat:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(236, 72, 153, 0.4);
        color: white;
    }
    
    .btn-edit {
        background: #fef3c7;
        color: #92400e;
    }
    
    .btn-edit:hover {
        background: #fde68a;
        color: #78350f;
    }
    
    .btn-delete {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .btn-delete:hover {
        background: #fecaca;
        color: #7f1d1d;
    }
    
    .admin-actions {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 10px;
        margin-top: 10px;
    }
    
    .empty-state {
        text-align: center;
        padding: 100px 40px;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 24px;
        margin: 40px 0;
    }
    
    .empty-icon {
        font-size: 6rem;
        margin-bottom: 30px;
        opacity: 0.4;
    }
    
    .empty-title {
        font-size: 2rem;
        color: #1e293b;
        font-weight: 700;
        margin-bottom: 15px;
    }
    
    .empty-text {
        font-size: 1.1rem;
        color: #64748b;
        margin-bottom: 30px;
    }
    
    .stats-bar {
        display: flex;
        gap: 20px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }
    
    .stat-card {
        flex: 1;
        min-width: 200px;
        background: white;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        border-left: 4px solid #2a5298;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1e3c72;
        line-height: 1;
        margin-bottom: 8px;
    }
    
    .stat-label {
        font-size: 0.95rem;
        color: #64748b;
        font-weight: 600;
    }
    
    @media (max-width: 768px) {
        .students-grid {
            grid-template-columns: 1fr;
        }
        
        .page-header {
            padding: 40px 20px;
        }
        
        .page-header h1 {
            font-size: 2rem;
        }
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <h1 class="text-white">👨‍🏫 Mes Étudiants Stagiaires</h1>
    <p>Suivez et accompagnez vos étudiants tout au long de leur stage</p>
</div>

<!-- Statistics Bar -->
<div class="stats-bar">
    <div class="stat-card">
        <div class="stat-number">{{ $stages->total() }}</div>
        <div class="stat-label">Étudiants tutorés</div>
    </div>
    <div class="stat-card" style="border-left-color: #10b981;">
        <div class="stat-number" style="color: #059669;">{{ $stages->where('statut_validation', 'validé')->count() }}</div>
        <div class="stat-label">Stages validés</div>
    </div>
    <div class="stat-card" style="border-left-color: #f59e0b;">
        <div class="stat-number" style="color: #d97706;">{{ $stages->where('statut_validation', 'en_cours')->count() }}</div>
        <div class="stat-label">En cours</div>
    </div>
</div>

<!-- Students Grid -->
@forelse ($stages as $index => $stage)
<div class="students-grid">
    <div class="student-card">
        <div class="card-banner card-banner-{{ ($index % 5) + 1 }}">
            <div class="card-avatar">
                {{ strtoupper(substr($stage->inscriptionAdmin->etudiant->nom ?? 'E', 0, 1)) }}{{ strtoupper(substr($stage->inscriptionAdmin->etudiant->prenom ?? 'T', 0, 1)) }}
            </div>
        </div>
        
        <div class="card-body">
            <h3 class="student-name">{{ $stage->inscriptionAdmin->etudiant->nom ?? 'N/A' }} {{ $stage->inscriptionAdmin->etudiant->prenom ?? '' }}</h3>
            <span class="student-badge badge-{{ strtolower(str_replace('_', '-', $stage->statut_validation)) }}">
                {{ ucfirst(str_replace('_', ' ', $stage->statut_validation)) }}
            </span>
            
            <div class="info-section">
                <div class="info-row">
                    <div class="info-icon">
                        <i class='bx bx-buildings'></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Entreprise</div>
                        <div class="info-text">{{ $stage->entreprise->nom_entreprise ?? 'Non renseignée' }}</div>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-icon" style="background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);">
                        <i class='bx bx-calendar'></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Période de stage</div>
                        <div class="info-text">{{ \Carbon\Carbon::parse($stage->date_debut)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($stage->date_fin)->format('d/m/Y') }}</div>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class='bx bx-time'></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Durée</div>
                        <div class="info-text">
                            {{ \Carbon\Carbon::parse($stage->date_debut)->diffInDays(\Carbon\Carbon::parse($stage->date_fin)) }} jours
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-actions">
                <a href="{{ route('stages.stages.show', $stage) }}" class="action-btn btn-primary-action">
                    <i class='bx bx-show'></i> Voir le dossier
                </a>
                
                <a href="{{ route('chat.etudiant', $stage->inscriptionAdmin->etudiant->id ?? '#') }}" class="action-btn btn-chat">
                    <i class='bx bx-message-dots'></i> Discuter
                </a>
                
                <a href="mailto:{{ $stage->inscriptionAdmin->etudiant->email ?? '#' }}" class="action-btn btn-secondary-action">
                    <i class='bx bx-envelope'></i> Email
                </a>
            </div>
            
            @can('gerer_stages')
            <div class="admin-actions">
                <a href="{{ route('stages.stages.edit', $stage) }}" class="action-btn btn-edit">
                    <i class='bx bx-edit-alt'></i> Modifier
                </a>
                
                <form action="{{ route('stages.stages.destroy', $stage) }}" method="POST" style="display: contents;" onsubmit="return confirm('⚠️ Confirmer la suppression de ce stage ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn btn-delete">
                        <i class='bx bx-trash'></i> Supprimer
                    </button>
                </form>
                
                <a href="{{ route('stages.stages.create') }}" class="action-btn btn-secondary-action">
                    <i class='bx bx-plus'></i> Nouveau
                </a>
            </div>
            @endcan
        </div>
    </div>
</div>
@empty
<div class="empty-state">
    <div class="empty-icon">📚</div>
    <h2 class="empty-title">Aucun étudiant à tutorer</h2>
    <p class="empty-text">Vous n'avez pas encore d'étudiants stagiaires assignés</p>
    @can('gerer_stages')
    <a href="{{ route('stages.stages.create') }}" class="action-btn btn-primary-action" style="display: inline-flex; width: auto;">
        <i class='bx bx-plus'></i> Affecter un premier stage
    </a>
    @endcan
</div>
@endforelse

<!-- Pagination -->
@if($stages->hasPages())
<div class="mt-4 d-flex justify-content-center">
    {{ $stages->links() }}
</div>
@endif

@endsection