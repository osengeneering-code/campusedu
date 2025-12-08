@extends('layouts.admin')

@section('titre', 'Messagerie')

@section('header')
<style>
    .conversation-item {
        transition: all 0.2s ease;
        cursor: pointer;
        border-radius: 8px;
        margin: 4px 8px;
    }
    .conversation-item:hover {
        background-color: #f8f9fa !important;
        transform: translateX(4px);
    }
    .conversation-item.active {
        background-color: #e7f3ff !important;
        border-left: 3px solid #0d6efd;
    }
    .message-bubble {
        border-radius: 18px;
        max-width: 70%;
        word-wrap: break-word;
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .message-bubble-sent {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    .message-bubble-received {
        background-color: #ffffff;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        border: 1px solid #e9ecef;
    }
    .typing-indicator {
        display: none;
    }
    .typing-indicator.active {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 10px 15px;
        background-color: #f1f3f5;
        border-radius: 18px;
        width: fit-content;
    }
    .typing-dot {
        width: 8px;
        height: 8px;
        background-color: #adb5bd;
        border-radius: 50%;
        animation: typing 1.4s infinite;
    }
    .typing-dot:nth-child(2) { animation-delay: 0.2s; }
    .typing-dot:nth-child(3) { animation-delay: 0.4s; }
    @keyframes typing {
        0%, 60%, 100% { transform: translateY(0); }
        30% { transform: translateY(-10px); }
    }
    .online-status {
        width: 12px;
        height: 12px;
        border: 2px solid white;
        border-radius: 50%;
        position: absolute;
        bottom: 0;
        right: 0;
    }
    .avatar-sm { width: 40px; height: 40px; }
    .avatar-md { width: 50px; height: 50px; }
    .avatar-xl { width: 80px; height: 80px; }
    .message-time {
        font-size: 0.75rem;
        opacity: 0.7;
    }
    #messagesContainer {
        scrollbar-width: thin;
        scrollbar-color: #888 #f1f1f1;
    }
    #messagesContainer::-webkit-scrollbar {
        width: 6px;
    }
    #messagesContainer::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    #messagesContainer::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    #messagesContainer::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    .file-preview {
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        background-color: rgba(255,255,255,0.2);
        border-radius: 8px;
        margin-top: 8px;
    }
    .file-preview-item {
        position: relative;
        padding: 8px 12px;
        background-color: #f8f9fa;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .file-preview-item .remove-file {
        cursor: pointer;
        color: #dc3545;
        font-size: 1.2rem;
        line-height: 1;
    }
    .emoji-picker {
        position: absolute;
        bottom: 60px;
        left: 0;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        display: none;
        z-index: 1000;
        max-height: 200px;
        overflow-y: auto;
    }
    .emoji-picker.show {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        gap: 5px;
    }
    .emoji-item {
        font-size: 1.5rem;
        cursor: pointer;
        padding: 5px;
        border-radius: 4px;
        transition: background-color 0.2s;
        text-align: center;
    }
    .emoji-item:hover {
        background-color: #f8f9fa;
        transform: scale(1.2);
    }
    .date-divider {
        text-align: center;
        margin: 20px 0;
        position: relative;
    }
    .date-divider span {
        background-color: #e9ecef;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        color: #6c757d;
        font-weight: 500;
    }
    .min-width-0 {
        min-width: 0;
    }
    .message-input-wrapper {
        position: relative;
    }
    .btn-light:hover {
        background-color: #e9ecef;
    }
    .conversation-list-wrapper {
        max-height: calc(100vh - 250px);
        overflow-y: auto;
    }
    .empty-state {
        padding: 40px 20px;
    }
    .badge-online {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 10px;
        height: 10px;
        background-color: #28a745;
        border: 2px solid white;
        border-radius: 50%;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow-sm border-0">
            <div class="row g-0" style="height: calc(100vh - 100px);">
                
                {{-- Sidebar Gauche: Liste des Conversations --}}
                <div class="col-lg-3 border-end d-flex flex-column">
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
                                       class="list-group-item list-group-item-action border-0 conversation-item {{ request()->route('conversation')?->id == $conv->id ? 'active' : '' }}">
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
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#newConversationModal">
                                            Démarrer une conversation
                                        </button>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- Chats directs --}}
                        <div class="tab-pane fade" id="directChats">
                            <div class="list-group list-group-flush">
                                @forelse($conversations->where('is_group', false) as $conv)
                                    <a href="{{ route('conversations.show', $conv) }}" 
                                       class="list-group-item list-group-item-action border-0 conversation-item {{ request()->route('conversation')?->id == $conv->id ? 'active' : '' }}">
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
                                       class="list-group-item list-group-item-action border-0 conversation-item {{ request()->route('conversation')?->id == $conv->id ? 'active' : '' }}">
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
                </div>

                {{-- Zone Centrale: Messages --}}
                <div class="col-lg-6 d-flex flex-column">
                    @if(isset($selectedConversation))
                        {{-- Header de la conversation --}}
                        <div class="p-3 border-bottom bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    @if($selectedConversation->is_group)
                                        <div class="avatar avatar-md bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                            <i class="bx bx-group"></i>
                                        </div>
                                    @else
                                        <div class="position-relative me-3">
                                            <img src="{{ $selectedConversation->otherUser->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($selectedConversation->otherUser->name ?? 'User') }}" 
                                                 class="avatar avatar-md rounded-circle" alt="Avatar">
                                            @if($selectedConversation->otherUser->is_online ?? false)
                                                <span class="badge-online"></span>
                                            @endif
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ $selectedConversation->name ?? ($selectedConversation->otherUser->name ?? 'Conversation') }}</h6>
                                        @if(!$selectedConversation->is_group)
                                            <small class="text-muted">
                                                {{ ($selectedConversation->otherUser->is_online ?? false) ? 'En ligne' : 'Hors ligne' }}
                                            </small>
                                        @else
                                            <small class="text-muted">{{ $selectedConversation->members_count ?? 0 }} membres</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-light" title="Appel vocal">
                                        <i class="bx bx-phone"></i>
                                    </button>
                                    <button class="btn btn-sm btn-light" title="Appel vidéo">
                                        <i class="bx bx-video"></i>
                                    </button>
                                    <button class="btn btn-sm btn-light" title="Rechercher">
                                        <i class="bx bx-search"></i>
                                    </button>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#"><i class="bx bx-info-circle me-2"></i>Infos</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bx bx-bell-off me-2"></i>Muet</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="bx bx-trash me-2"></i>Supprimer</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Zone des messages --}}
                        <div class="flex-grow-1 overflow-auto p-4" id="messagesContainer" style="background: linear-gradient(to bottom, #f8f9fa 0%, #e9ecef 100%);">
                            @php
                                $currentDate = null;
                            @endphp
                            
                            @forelse($selectedConversation->messages ?? [] as $message)
                                {{-- Séparateur de date --}}
                                @php
                                    $messageDate = $message->created_at->format('Y-m-d');
                                @endphp
                                @if($currentDate !== $messageDate)
                                    @php $currentDate = $messageDate; @endphp
                                    <div class="date-divider">
                                        <span>
                                            @if($message->created_at->isToday())
                                                Aujourd'hui
                                            @elseif($message->created_at->isYesterday())
                                                Hier
                                            @else
                                                {{ $message->created_at->format('d M Y') }}
                                            @endif
                                        </span>
                                    </div>
                                @endif

                                <div class="mb-3 d-flex {{ $message->user_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                                    <div class="d-flex flex-column {{ $message->user_id == auth()->id() ? 'align-items-end' : 'align-items-start' }}" style="max-width: 75%;">
                                        @if($message->user_id != auth()->id() && $selectedConversation->is_group)
                                            <div class="d-flex align-items-center mb-1">
                                                <img src="{{ $message->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($message->user->name ?? 'User') . '&background=random' }}" 
                                                     class="rounded-circle me-2" style="width: 24px; height: 24px;" alt="Avatar">
                                                <small class="text-muted fw-medium">{{ $message->user->name ?? 'Utilisateur' }}</small>
                                            </div>
                                        @endif
                                        
                                        <div class="message-bubble {{ $message->user_id == auth()->id() ? 'message-bubble-sent' : 'message-bubble-received' }} p-3 shadow-sm">
                                            <p class="mb-0" style="white-space: pre-wrap;">{{ $message->body ?? '' }}</p>
                                            
                                            @if(isset($message->attachments) && count($message->attachments) > 0)
                                                <div class="mt-2">
                                                    @foreach($message->attachments as $attachment)
                                                        <div class="file-preview">
                                                            <i class="bx bx-file me-2"></i>
                                                            <a href="{{ $attachment->url }}" target="_blank" class="text-decoration-none {{ $message->user_id == auth()->id() ? 'text-white' : 'text-primary' }}">
                                                                {{ Str::limit($attachment->name ?? 'Fichier', 30) }}
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="message-time mt-1 d-flex align-items-center gap-1">
                                            <small class="text-muted">{{ $message->created_at->format('H:i') }}</small>
                                            @if($message->user_id == auth()->id())
                                                @if($message->is_read ?? false)
                                                    <i class="bx bx-check-double text-primary"></i>
                                                @else
                                                    <i class="bx bx-check text-muted"></i>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <div class="text-center">
                                        <i class="bx bx-message-alt-detail text-muted mb-3" style="font-size: 5rem; opacity: 0.3;"></i>
                                        <h5 class="text-muted">Aucun message</h5>
                                        <p class="text-muted">Soyez le premier à envoyer un message !</p>
                                    </div>
                                </div>
                            @endforelse

                            {{-- Indicateur de frappe --}}
                            <div class="typing-indicator mb-3" id="typingIndicator">
                                <div class="d-flex align-items-center">
                                    <img src="" class="rounded-circle me-2" style="width: 24px; height: 24px; display: none;" alt="Avatar" id="typingAvatar">
                                    <div class="d-flex gap-1 bg-white p-2 rounded-pill shadow-sm">
                                        <div class="typing-dot"></div>
                                        <div class="typing-dot"></div>
                                        <div class="typing-dot"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Formulaire d'envoi --}}
                        <div class="p-3 border-top bg-white position-relative message-input-wrapper">
                            {{-- Prévisualisation des fichiers --}}
                            <div id="filePreview" class="mb-2 d-none">
                                <div class="d-flex flex-wrap gap-2" id="filePreviewContainer"></div>
                            </div>

                            {{-- Emoji Picker --}}
                            <div class="emoji-picker" id="emojiPicker"></div>

                            <form action="{{ route('messages.store', $selectedConversation) }}" method="POST" enctype="multipart/form-data" id="messageForm">
                                @csrf
                                <div class="input-group">
                                    <button type="button" class="btn btn-light border-0" title="Emoji" id="emojiBtn">
                                        <i class="bx bx-smile fs-5"></i>
                                    </button>
                                    
                                    <input type="text" 
                                           name="body" 
                                           class="form-control border-0 shadow-none" 
                                           placeholder="Écrivez votre message..." 
                                           id="messageInput"
                                           autocomplete="off"
                                           required>
                                    
                                    <label for="fileAttachment" class="btn btn-light border-0 mb-0" title="Joindre un fichier">
                                        <i class="bx bx-paperclip fs-5"></i>
                                        <input type="file" id="fileAttachment" name="attachments[]" multiple hidden accept="image/*,.pdf,.doc,.docx,.txt">
                                    </label>
                                    
                                    <button type="submit" class="btn btn-primary px-4" id="sendBtn">
                                        <i class="bx bx-send"></i>
                                    </button>
                                </div>
                            </form>

                            {{-- Indicateur d'écriture --}}
                            <div class="mt-2">
                                <small class="text-muted" id="typingStatus"></small>
                            </div>
                        </div>
                    @else
                        {{-- État vide --}}
                        <div class="d-flex align-items-center justify-content-center h-100 flex-column">
                            <div class="text-center">
                                <i class="bx bx-message-square-detail text-primary" style="font-size: 5rem; opacity: 0.3;"></i>
                                <h5 class="mt-4 mb-2">Sélectionnez une conversation</h5>
                                <p class="text-muted">Choisissez une conversation à gauche pour commencer à discuter</p>
                               
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar Droite: Détails --}}
                <div class="col-lg-3 border-start d-flex flex-column bg-light">
                    @if(isset($selectedConversation))
                        <div class="p-4 text-center border-bottom bg-white">
                            @if($selectedConversation->is_group)
                                <div class="avatar avatar-xl bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                                    <i class="bx bx-group" style="font-size: 2rem;"></i>
                                </div>
                            @else
                                <img src="{{ $selectedConversation->otherUser->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($selectedConversation->otherUser->name ?? 'User') }}" 
                                     class="avatar avatar-xl rounded-circle mb-3" alt="Avatar">
                            @endif
                            <h5 class="mb-1">{{ $selectedConversation->name ?? ($selectedConversation->otherUser->name ?? 'Conversation') }}</h5>
                            @if(!$selectedConversation->is_group)
                                <p class="text-muted small mb-0">{{ $selectedConversation->otherUser->email ?? '' }}</p>
                            @endif
                        </div>

                        <div class="flex-grow-1 overflow-auto p-3">
                            {{-- À propos --}}
                            <div class="mb-4">
                                <h6 class="text-uppercase text-muted mb-3 fw-bold" style="font-size: 0.75rem;">À propos</h6>
                                <p class="small">{{ $selectedConversation->description ?? 'Aucune description disponible.' }}</p>
                            </div>

                            {{-- Membres (pour les groupes) --}}
                            @if($selectedConversation->is_group)
                                <div class="mb-4">
                                    <h6 class="text-uppercase text-muted mb-3 fw-bold" style="font-size: 0.75rem;">Membres ({{ $selectedConversation->members_count ?? 0 }})</h6>
                                    <div class="list-group list-group-flush">
                                        @foreach(($selectedConversation->members ?? []) as $member)
                                            <div class="list-group-item border-0 px-0 d-flex align-items-center py-2">
                                                <div class="position-relative me-3">
                                                    <img src="{{ $member->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($member->name ?? 'User') }}" 
                                                         class="avatar avatar-sm rounded-circle" alt="Avatar">
                                                    @if($member->is_online ?? false)
                                                        <span class="badge-online"></span>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1 min-width-0">
                                                    <div class="fw-medium">{{ $member->name ?? 'Utilisateur' }}</div>
                                                    <small class="text-muted">{{ $member->role ?? 'Membre' }}</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Fichiers partagés --}}
                            <div class="mb-4">
                                <h6 class="text-uppercase text-muted mb-3 fw-bold" style="font-size: 0.75rem;">Fichiers partagés</h6>
                                <div class="d-grid gap-2">
                                    @forelse(($selectedConversation->sharedFiles ?? []) as $file)
                                        <a href="{{ $file->url ?? '#' }}" class="btn btn-light btn-sm text-start d-flex align-items-center" target="_blank">
                                            <i class="bx bx-file me-2"></i>
                                            <span class="text-truncate">{{ $file->name ?? 'Fichier' }}</span>
                                        </a>
                                    @empty
                                        <p class="text-muted small mb-0">Aucun fichier partagé</p>
                                    @endforelse
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="mb-4">
                                <h6 class="text-uppercase text-muted mb-3 fw-bold" style="font-size: 0.75rem;">Actions</h6>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-light btn-sm text-start">
                                        <i class="bx bx-bell-off me-2"></i>Désactiver notifications
                                    </button>
                                    <button class="btn btn-light btn-sm text-start">
                                        <i class="bx bx-search me-2"></i>Rechercher dans la conversation
                                    </button>
                                    @if($selectedConversation->is_group)
                                        <button class="btn btn-light btn-sm text-start">
                                            <i class="bx bx-log-out me-2"></i>Quitter le groupe
                                        </button>
                                    @endif
                                    <button class="btn btn-danger btn-sm text-start">
                                        <i class="bx bx-trash me-2"></i>Supprimer la conversation
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <div class="text-center p-4">
                                <i class="bx bx-info-circle text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                                <p class="text-muted">Sélectionnez une conversation pour voir les détails</p>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('footer')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-scroll vers le bas des messages
    const messagesContainer = document.getElementById('messagesContainer');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Recherche de conversations
    const searchInput = document.getElementById('searchConversation');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.conversation-item').forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // Toggle champ nom de groupe et description
    const conversationType = document.getElementById('conversationType');
    const groupNameField = document.getElementById('groupNameField');
    const groupDescriptionField = document.getElementById('groupDescriptionField');
    
    if (conversationType) {
        conversationType.addEventListener('change', function(e) {
            if (e.target.value === 'group') {
                groupNameField?.classList.remove('d-none');
                groupDescriptionField?.classList.remove('d-none');
            } else {
                groupNameField?.classList.add('d-none');
                groupDescriptionField?.classList.add('d-none');
            }
        });
    }

    // Gestion des emojis
    const emojiBtn = document.getElementById('emojiBtn');
    const emojiPicker = document.getElementById('emojiPicker');
    const messageInput = document.getElementById('messageInput');
    
    const emojis = ['😀','😃','😄','😁','😅','😂','🤣','😊','😇','🙂','🙃','😉','😌','😍','🥰','😘','😗','😙','😚','😋','😛','😝','😜','🤪','🤨','🧐','🤓','😎','🤩','🥳','😏','😒','😞','😔','😟','😕','🙁','☹️','😣','😖','😫','😩','🥺','😢','😭','😤','😠','😡','🤬','🤯','😳','🥵','🥶','😱','😨','😰','😥','😓','🤗','🤔','🤭','🤫','🤥','😶','😐','😑','😬','🙄','😯','😦','😧','😮','😲','🥱','😴','🤤','😪','😵','🤐','🥴','🤢','🤮','🤧','😷','🤒','🤕','🤑','🤠','👍','👎','👌','✌️','🤞','🤟','🤘','🤙','👈','👉','👆','👇','☝️','✋','🤚','🖐️','🖖','👋','🤝','🙏','💪','🦾','🦿','🦵','🦶','👂','🦻','👃','🧠','🫀','🫁','🦷','🦴','👀','👁️','👅','👄','💋','❤️','🧡','💛','💚','💙','💜','🖤','🤍','🤎','💔','❣️','💕','💞','💓','💗','💖','💘','💝','🔥','✨','💫','⭐','🌟','✅','❌'];
    
    if (emojiBtn && emojiPicker && messageInput) {
        // Remplir le picker d'emojis
        emojis.forEach(emoji => {
            const span = document.createElement('span');
            span.className = 'emoji-item';
            span.textContent = emoji;
            span.addEventListener('click', function() {
                messageInput.value += emoji;
                messageInput.focus();
                emojiPicker.classList.remove('show');
            });
            emojiPicker.appendChild(span);
        });

        // Toggle emoji picker
        emojiBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            emojiPicker.classList.toggle('show');
        });

        // Fermer le picker en cliquant ailleurs
        document.addEventListener('click', function(e) {
            if (!emojiPicker.contains(e.target) && e.target !== emojiBtn) {
                emojiPicker.classList.remove('show');
            }
        });
    }

    // Gestion des fichiers joints
    const fileAttachment = document.getElementById('fileAttachment');
    const filePreview = document.getElementById('filePreview');
    const filePreviewContainer = document.getElementById('filePreviewContainer');
    
    if (fileAttachment && filePreview && filePreviewContainer) {
        fileAttachment.addEventListener('change', function(e) {
            filePreviewContainer.innerHTML = '';
            
            if (e.target.files.length > 0) {
                filePreview.classList.remove('d-none');
                
                Array.from(e.target.files).forEach((file, index) => {
                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-preview-item';
                    fileItem.innerHTML = `
                        <i class="bx bx-file"></i>
                        <span class="text-truncate" style="max-width: 150px;">${file.name}</span>
                        <span class="remove-file" data-index="${index}">×</span>
                    `;
                    filePreviewContainer.appendChild(fileItem);
                });

                // Supprimer un fichier
                document.querySelectorAll('.remove-file').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        const dt = new DataTransfer();
                        const files = Array.from(fileAttachment.files);
                        
                        files.forEach((file, i) => {
                            if (i !== index) dt.items.add(file);
                        });
                        
                        fileAttachment.files = dt.files;
                        
                        if (dt.files.length === 0) {
                            filePreview.classList.add('d-none');
                        } else {
                            // Rafraîchir l'aperçu
                            fileAttachment.dispatchEvent(new Event('change'));
                        }
                    });
                });
            } else {
                filePreview.classList.add('d-none');
            }
        });
    }

    // Focus sur l'input au chargement
    if (messageInput) {
        messageInput.focus();
    }

    // Empêcher l'envoi de messages vides
    const messageForm = document.getElementById('messageForm');
    if (messageForm && messageInput) {
        messageForm.addEventListener('submit', function(e) {
            if (!messageInput.value.trim() && (!fileAttachment || fileAttachment.files.length === 0)) {
                e.preventDefault();
                messageInput.focus();
            }
        });
    }

    // Raccourci clavier Entrée pour envoyer
    if (messageInput && messageForm) {
        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                messageForm.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
            }
        });
    }
});
</script>
@endsection