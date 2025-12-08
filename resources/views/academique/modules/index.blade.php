@extends('layouts.admin')

@section('titre', 'Gestion des Modules (Matières)')

@section('content')
<style>
    .modules-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 50px 40px;
        border-radius: 20px;
        margin-bottom: 40px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(102, 126, 234, 0.3);
    }
    
    .modules-header::before {
        content: '📚';
        position: absolute;
        font-size: 15rem;
        opacity: 0.1;
        right: -50px;
        top: -40px;
        transform: rotate(-15deg);
    }
    
    .modules-header h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 10px;
        position: relative;
        z-index: 2;
    }
    
    .modules-header p {
        font-size: 1.1rem;
        opacity: 0.95;
        position: relative;
        z-index: 2;
    }
    
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 35px;
    }
    
    .stat-box {
        background: white;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border-left: 4px solid #667eea;
        transition: all 0.3s ease;
    }
    
    .stat-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(102, 126, 234, 0.2);
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #667eea;
        line-height: 1;
        margin-bottom: 8px;
    }
    
    .stat-label {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .modules-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }
    
    .module-card {
        background: white;
        border-radius: 18px;
        padding: 30px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
    }
    
    .module-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    }
    
    .module-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(102, 126, 234, 0.2);
        border-color: #667eea;
    }
    
    .module-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }
    
    .module-code {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 8px 18px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .module-actions {
        display: flex;
        gap: 8px;
    }
    
    .action-icon-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1.1rem;
    }
    
    .btn-edit-icon {
        background: #fef3c7;
        color: #92400e;
    }
    
    .btn-edit-icon:hover {
        background: #fde68a;
        transform: scale(1.1);
    }
    
    .btn-delete-icon {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .btn-delete-icon:hover {
        background: #fecaca;
        transform: scale(1.1);
    }
    
    .module-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        line-height: 1.3;
    }
    
    .module-details {
        display: grid;
        gap: 12px;
    }
    
    .detail-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: #f8fafc;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .detail-row:hover {
        background: #e2e8f0;
    }
    
    .detail-icon {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        flex-shrink: 0;
    }
    
    .detail-content {
        flex: 1;
    }
    
    .detail-label {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }
    
    .detail-value {
        font-size: 0.95rem;
        color: #1e293b;
        font-weight: 600;
    }
    
    .badge-info {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .badge-coefficient {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .badge-hours {
        background: #fce7f3;
        color: #9f1239;
    }
    
    .add-module-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 14px 32px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 1.05rem;
        border: none;
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }
    
    .add-module-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(16, 185, 129, 0.5);
        color: white;
    }
    
    .empty-state {
        text-align: center;
        padding: 80px 40px;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 20px;
        margin: 40px 0;
    }
    
    .empty-icon {
        font-size: 6rem;
        margin-bottom: 25px;
        opacity: 0.4;
    }
    
    .empty-title {
        font-size: 1.8rem;
        color: #1e293b;
        font-weight: 700;
        margin-bottom: 12px;
    }
    
    .empty-text {
        font-size: 1.05rem;
        color: #64748b;
        margin-bottom: 30px;
    }
    
    .filters-bar {
        background: white;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        margin-bottom: 30px;
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .filter-label {
        font-weight: 600;
        color: #475569;
    }
    
    @media (max-width: 768px) {
        .modules-grid {
            grid-template-columns: 1fr;
        }
        
        .modules-header {
            padding: 30px 20px;
        }
        
        .modules-header h1 {
            font-size: 2rem;
        }
        
        .stats-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Header -->
<div class="modules-header">
    <h1>📚 Gestion des Modules</h1>
    <p>Organisez et gérez tous les modules académiques de votre établissement</p>
</div>

<!-- Statistics -->
<div class="stats-container">
    <div class="stat-box">
        <div class="stat-number">{{ $modules->total() }}</div>
        <div class="stat-label">Modules totaux</div>
    </div>
    <div class="stat-box" style="border-left-color: #10b981;">
        <div class="stat-number" style="color: #10b981;">{{ $modules->sum('volume_horaire') }}</div>
        <div class="stat-label">Heures au total</div>
    </div>
    <div class="stat-box" style="border-left-color: #f59e0b;">
        <div class="stat-number" style="color: #f59e0b;">{{ $modules->unique('ue_id')->count() }}</div>
        <div class="stat-label">Unités d'enseignement</div>
    </div>
    <div class="stat-box" style="border-left-color: #ec4899;">
        <div class="stat-number" style="color: #ec4899;">{{ number_format($modules->avg('coefficient'), 1) }}</div>
        <div class="stat-label">Coeff. moyen</div>
    </div>
</div>

<!-- Add Button -->
<div class="text-end mb-4">
    <a href="{{ route('academique.modules.create') }}" class="add-module-btn">
        <i class='bx bx-plus-circle'></i> Ajouter un module
    </a>
</div>

<!-- Modules Grid -->
<div class="modules-grid">
@forelse ($modules as $module)
    <div class="module-card">
        <div class="module-header">
            <span class="module-code">{{ $module->code_module }}</span>
            <div class="module-actions">
                <a href="{{ route('academique.modules.edit', $module) }}" class="action-icon-btn btn-edit-icon" title="Modifier">
                    <i class='bx bx-edit-alt'></i>
                </a>
                <form action="{{ route('academique.modules.destroy', $module) }}" method="POST" style="display: inline;" onsubmit="return confirm('⚠️ Confirmer la suppression de ce module ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-icon-btn btn-delete-icon" title="Supprimer">
                        <i class='bx bx-trash'></i>
                    </button>
                </form>
            </div>
        </div>
        
        <h3 class="module-title">{{ $module->libelle }}</h3>
        
        <div class="module-details">
            <div class="detail-row">
                <div class="detail-icon">
                    <i class='bx bx-book-bookmark'></i>
                </div>
                <div class="detail-content">
                    <div class="detail-label">Unité d'enseignement</div>
                    <div class="detail-value">{{ $module->ue->libelle ?? 'Non assignée' }}</div>
                </div>
            </div>
            
            <div class="detail-row">
                <div class="detail-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class='bx bx-calendar-alt'></i>
                </div>
                <div class="detail-content">
                    <div class="detail-label">Semestre & Niveau</div>
                    <div class="detail-value">{{ $module->ue->semestre->libelle ?? 'N/A' }} - {{ $module->ue->semestre->niveau ?? '' }}</div>
                </div>
            </div>
            
            <div class="detail-row">
                <div class="detail-icon" style="background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);">
                    <i class='bx bx-time-five'></i>
                </div>
                <div class="detail-content">
                    <div class="detail-label">Informations horaires</div>
                    <div class="detail-value">
                        <span class="badge-info badge-coefficient">
                            <i class='bx bx-trending-up'></i> Coef. {{ $module->coefficient }}
                        </span>
                        <span class="badge-info badge-hours">
                            <i class='bx bx-time'></i> {{ $module->volume_horaire }}h
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
<div class="empty-state">
    <div class="empty-icon">📖</div>
    <h2 class="empty-title">Aucun module disponible</h2>
    <p class="empty-text">Commencez par créer votre premier module académique</p>
    <a href="{{ route('academique.modules.create') }}" class="add-module-btn">
        <i class='bx bx-plus-circle'></i> Créer le premier module
    </a>
</div>
@endforelse
</div>

<!-- Pagination -->
@if($modules->hasPages())
<div class="mt-4 d-flex justify-content-center">
    {{ $modules->links() }}
</div>
@endif

@endsection