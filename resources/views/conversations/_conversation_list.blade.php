{{-- Header avec recherche --}}
<div class="p-3 border-bottom">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0 fw-bold">Messagerie</h5>
        <a href="{{ route('conversations.create') }}" class="btn btn-primary btn-sm">
            <i class="bx bx-plus"></i> Nouvelle conversation
        </a>
    </div>
    <div class="input-group input-group-sm">
        <span class="input-group-text bg-white border-end-0">
            <i class="bx bx-search"></i>
        </span>
        <input type="text" class="form-control border-start-0" placeholder="Rechercher..." id="searchConversation">
    </div>
</div>

{{-- Onglets: Tous / Utilisateurs / Groupes --}}
<ul class="nav nav-tabs px-3 pt-2 border-bottom" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#allChats" type="button">
            Tous
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#directChats" type="button">
            <i class="bx bx-user me-1"></i> Directs
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#groupChats" type="button">
            <i class="bx bx-group me-1"></i> Groupes
        </button>
    </li>
</ul>

{{-- Liste des Conversations --}}
<div class="tab-content flex-grow-1 overflow-auto">
    {{-- Tous les chats --}}
    <div class="tab-pane fade show active" id="allChats">
        <div class="list-group list-group-flush">
            @forelse($conversations as $conv)
                <a href="{{ route('conversations.show', $conv) }}" 
                   class="list-group-item list-group-item-action border-0 conversation-item {{ isset($currentConversationId) && $currentConversationId == $conv->id ? 'active' : '' }}">
                    <div class="d-flex align-items-start">
                        {{-- Avatar --}}
                        <div class="position-relative me-3">
                            @if($conv->is_group)
                                <div class="avatar avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bx bx-group"></i>
                                </div>
                            @else
                                <img src="{{ $conv->otherUser->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($conv->otherUser->name ?? 'User') }}" 
                                     class="avatar avatar-sm rounded-circle" alt="Avatar">
                                @if($conv->otherUser->is_online ?? false)
                                    <span class="badge-online"></span>
                                @endif
                            @endif
                        </div>
                        
                        {{-- Infos conversation --}}
                        <div class="flex-grow-1 min-width-0">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="mb-0 text-truncate">
                                    {{ $conv->name ?? ($conv->is_group ? 'Groupe #' . $conv->id : ($conv->otherUser->name ?? 'Utilisateur')) }}
                                </h6>
                                <small class="text-muted">{{ $conv->updated_at->diffForHumans(null, true) }}</small>
                            </div>
                            
                            @if($conv->lastMessage)
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-0 text-muted small text-truncate">
                                        @if($conv->lastMessage->user_id == auth()->id())
                                            <i class="bx bx-check-double {{ $conv->lastMessage->is_read ? 'text-primary' : '' }}"></i>
                                            Vous: 
                                        @else
                                            <strong>{{ $conv->lastMessage->user->name ?? 'Utilisateur' }}:</strong>
                                        @endif
                                        {{ Str::limit($conv->lastMessage->body ?? '', 35) }}
                                    </p>
                                    @if(($conv->unread_count ?? 0) > 0)
                                        <span class="badge bg-primary rounded-pill ms-2">{{ $conv->unread_count }}</span>
                                    @endif
                                </div>
                            @else
                                <p class="mb-0 text-muted small">Aucun message</p>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-5 empty-state">
                    <i class="bx bx-message-square-detail text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-2">Aucune conversation</p>
                    <a href="{{ route('conversations.create') }}" class="btn btn-sm btn-primary">
                        Démarrer une conversation
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Chats directs --}}
    <div class="tab-pane fade" id="directChats">
        <div class="list-group list-group-flush">
            @forelse($conversations->where('is_group', false) as $conv)
                <a href="{{ route('conversations.show', $conv) }}" 
                   class="list-group-item list-group-item-action border-0 conversation-item {{ isset($currentConversationId) && $currentConversationId == $conv->id ? 'active' : '' }}">
                    <div class="d-flex align-items-start">
                        <div class="position-relative me-3">
                            <img src="{{ $conv->otherUser->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($conv->otherUser->name ?? 'User') }}" 
                                 class="avatar avatar-sm rounded-circle" alt="Avatar">
                            @if($conv->otherUser->is_online ?? false)
                                <span class="badge-online"></span>
                            @endif
                        </div>
                        <div class="flex-grow-1 min-width-0">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="mb-0 text-truncate">{{ $conv->otherUser->name ?? 'Utilisateur' }}</h6>
                                <small class="text-muted">{{ $conv->updated_at->diffForHumans(null, true) }}</small>
                            </div>
                            @if($conv->lastMessage)
                                <p class="mb-0 text-muted small text-truncate">
                                    {{ Str::limit($conv->lastMessage->body ?? '', 40) }}
                                </p>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-5 empty-state">
                    <i class="bx bx-user text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-2">Aucun chat direct</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Groupes --}}
    <div class="tab-pane fade" id="groupChats">
        <div class="list-group list-group-flush">
            @forelse($conversations->where('is_group', true) as $conv)
                <a href="{{ route('conversations.show', $conv) }}" 
                   class="list-group-item list-group-item-action border-0 conversation-item {{ isset($currentConversationId) && $currentConversationId == $conv->id ? 'active' : '' }}">
                    <div class="d-flex align-items-start">
                        <div class="position-relative me-3">
                            <div class="avatar avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bx bx-group"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 min-width-0">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="mb-0 text-truncate">{{ $conv->name ?? 'Groupe #' . $conv->id }}</h6>
                                <small class="text-muted">{{ $conv->updated_at->diffForHumans(null, true) }}</small>
                            </div>
                            <p class="mb-0 text-muted small">{{ $conv->members_count ?? 0 }} membres</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-5 empty-state">
                    <i class="bx bx-group text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-2">Aucun groupe</p>
                </div>
            @endforelse
        </div>
    </div>
</div>