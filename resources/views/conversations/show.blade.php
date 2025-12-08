@extends('layouts.admin')

@section('titre', 'Conversation')

@section('header')
<style>
    .conversation-container {
        height: calc(100vh - 120px);
        max-height: 900px;
    }
    .conversation-sidebar {
        border-right: 1px solid #e3e6f0;
        background-color: #fff;
    }
    .conversation-item {
        transition: all 0.2s ease;
        cursor: pointer;
        border-radius: 8px;
        margin: 4px 8px;
        padding: 12px;
    }
    .conversation-item:hover {
        background-color: #f8f9fc;
        transform: translateX(4px);
    }
    .conversation-item.active {
        background-color: #e7f3ff;
        border-left: 3px solid #4e73df;
    }
    .messages-container {
        height: calc(100% - 140px);
        overflow-y: auto;
        padding: 20px;
        background: linear-gradient(to bottom, #f8f9fc 0%, #eaecf4 100%);
        scrollbar-width: thin;
        scrollbar-color: #858796 #f8f9fc;
    }
    .messages-container::-webkit-scrollbar {
        width: 6px;
    }
    .messages-container::-webkit-scrollbar-track {
        background: #f8f9fc;
        border-radius: 10px;
    }
    .messages-container::-webkit-scrollbar-thumb {
        background: #858796;
        border-radius: 10px;
    }
    .messages-container::-webkit-scrollbar-thumb:hover {
        background: #5a5c69;
    }
    .message-bubble {
        max-width: 70%;
        border-radius: 18px;
        padding: 12px 16px;
        word-wrap: break-word;
        animation: fadeInUp 0.3s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .message-bubble-sent {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
    }
    .message-bubble-received {
        background-color: #ffffff;
        border: 1px solid #e3e6f0;
    }
    .message-time {
        font-size: 0.7rem;
        opacity: 0.8;
        margin-top: 4px;
    }
    .message-sender {
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 4px;
        opacity: 0.9;
    }
    .avatar-sm {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }
    .avatar-xs {
        width: 32px;
        height: 32px;
        border-radius: 50%;
    }
    .badge-online {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 12px;
        height: 12px;
        background-color: #1cc88a;
        border: 2px solid white;
        border-radius: 50%;
    }
    .message-input-area {
        background-color: white;
        border-top: 1px solid #e3e6f0;
        padding: 16px;
    }
    .file-preview-container {
        padding: 12px;
        background-color: #f8f9fc;
        border-radius: 8px;
        margin-bottom: 12px;
    }
    .file-preview-item {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        background-color: white;
        border-radius: 6px;
        border: 1px solid #e3e6f0;
    }
    .file-preview-item .remove-file {
        cursor: pointer;
        color: #e74a3b;
        font-size: 1.2rem;
        line-height: 1;
        margin-left: auto;
    }
    .file-preview-item .remove-file:hover {
        color: #be2617;
    }
    .attachment-display {
        margin-top: 8px;
    }
    .attachment-display img {
        max-height: 200px;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .attachment-display img:hover {
        transform: scale(1.02);
    }
    .attachment-file {
        display: flex;
        align-items: center;
        padding: 10px;
        background-color: rgba(255,255,255,0.2);
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .attachment-file:hover {
        background-color: rgba(255,255,255,0.3);
        transform: translateX(4px);
    }
    .message-bubble-sent .attachment-file {
        color: white;
    }
    .message-bubble-received .attachment-file {
        color: #5a5c69;
    }
    .date-divider {
        text-align: center;
        margin: 20px 0;
        position: relative;
    }
    .date-divider span {
        background-color: #e3e6f0;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        color: #858796;
        font-weight: 600;
    }
    .typing-indicator {
        display: none;
        align-items: center;
        gap: 4px;
        padding: 10px 15px;
        background-color: white;
        border-radius: 18px;
        width: fit-content;
        margin-bottom: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .typing-indicator.active {
        display: flex;
    }
    .typing-dot {
        width: 8px;
        height: 8px;
        background-color: #858796;
        border-radius: 50%;
        animation: typing 1.4s infinite;
    }
    .typing-dot:nth-child(1) { animation-delay: 0s; }
    .typing-dot:nth-child(2) { animation-delay: 0.2s; }
    .typing-dot:nth-child(3) { animation-delay: 0.4s; }
    @keyframes typing {
        0%, 60%, 100% { transform: translateY(0); }
        30% { transform: translateY(-8px); }
    }
    .conversation-header {
        background-color: white;
        border-bottom: 1px solid #e3e6f0;
        padding: 16px 20px;
    }
    .empty-state {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #858796;
    }
    .empty-state i {
        font-size: 4rem;
        opacity: 0.3;
        margin-bottom: 16px;
    }
    .btn-icon {
        width: 38px;
        height: 38px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }
    .input-group-custom {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .message-input {
        flex: 1;
        border: 1px solid #d1d3e2;
        border-radius: 20px;
        padding: 10px 20px;
        font-size: 0.9rem;
    }
    .message-input:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        outline: 0;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        
        <div class="card shadow-sm">
            <div class="row g-0 conversation-container">
                
                {{-- Sidebar: Liste des conversations --}}
                <div class="col-lg-4 col-xl-3 conversation-sidebar d-flex flex-column">
                    <div class="p-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0 fw-bold">Conversations</h5>
                            <a href="{{ route('conversations.create') }}" class="btn btn-primary btn-sm">
                                <i class="bx bx-plus"></i>
                            </a>
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bx bx-search"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Rechercher..." id="searchConversations">
                        </div>
                    </div>

                    <div class="flex-grow-1 overflow-auto">
                        @forelse($allConversations ?? [] as $conv)
                            <a href="{{ route('conversations.show', $conv) }}" 
                               class="conversation-item d-block text-decoration-none {{ $conv->id == $conversation->id ? 'active' : '' }}">
                                <div class="d-flex align-items-start">
                                    <div class="position-relative me-3">
                                        @if($conv->is_group ?? false)
                                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bx bx-group"></i>
                                            </div>
                                        @else
                                            <img src="{{ $conv->otherUser->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($conv->otherUser->name ?? 'User') }}" 
                                                 class="avatar-sm" alt="Avatar">
                                            @if($conv->otherUser->is_online ?? false)
                                                <span class="badge-online"></span>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 min-width-0">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="mb-0 text-truncate fw-bold">
                                                {{ $conv->name ?? ($conv->is_group ?? false ? 'Groupe' : ($conv->otherUser->name ?? 'Utilisateur')) }}
                                            </h6>
                                            <small class="text-muted">{{ $conv->updated_at->diffForHumans(null, true) }}</small>
                                        </div>
                                        @if($conv->lastMessage ?? null)
                                            <p class="mb-0 text-muted small text-truncate">
                                                {{ Str::limit($conv->lastMessage->body ?? 'Fichier joint', 40) }}
                                            </p>
                                        @else
                                            <p class="mb-0 text-muted small">Aucun message</p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center p-4">
                                <i class="bx bx-message-square-detail text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-2">Aucune conversation</p>
                                <a href="{{ route('conversations.create') }}" class="btn btn-sm btn-primary">
                                    Créer une conversation
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Zone principale: Messages --}}
                <div class="col-lg-8 col-xl-9 d-flex flex-column">
                    
                    {{-- Header de la conversation --}}
                    <div class="conversation-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                @if($conversation->is_group ?? false)
                                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <i class="bx bx-group"></i>
                                    </div>
                                @else
                                    <div class="position-relative me-3">
                                        @php
                                            $otherUser = $conversation->participants->where('id', '!=', Auth::id())->first();
                                        @endphp
                                        <img src="{{ $otherUser->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($otherUser->name ?? 'User') }}" 
                                             class="avatar-sm" alt="Avatar">
                                        @if($otherUser->is_online ?? false)
                                            <span class="badge-online"></span>
                                        @endif
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-0 fw-bold">
                                        {{ $conversation->name ?? ($conversation->is_group ?? false ? 'Groupe #' . $conversation->id : ($otherUser->name ?? 'Conversation')) }}
                                    </h6>
                                    @if($conversation->is_group ?? false)
                                        <small class="text-muted">
                                            {{ $conversation->participants->count() }} participants
                                        </small>
                                    @else
                                        <small class="text-muted">
                                            {{ ($otherUser->is_online ?? false) ? 'En ligne' : 'Hors ligne' }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-light btn-icon" title="Appel vocal">
                                    <i class="bx bx-phone"></i>
                                </button>
                                <button class="btn btn-light btn-icon" title="Appel vidéo">
                                    <i class="bx bx-video"></i>
                                </button>
                                <div class="dropdown">
                                    <button class="btn btn-light btn-icon" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#"><i class="bx bx-info-circle me-2"></i>Infos</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bx bx-search me-2"></i>Rechercher</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="bx bx-trash me-2"></i>Supprimer</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Zone des messages --}}
                    <div class="messages-container" id="messagesContainer" 
                         style="position: relative; 
                                background-image: url('{{ asset('Pro/logo/1.png') }}'), linear-gradient(to bottom, #f8f9fa46 0%, #e9ecef5a 80%);
                                background-repeat: no-repeat;
                                background-position: center;
                                background-size: 915px;
                                background-blend-mode: overlay;
                                opacity: 0.8;">
                        
                            @php
                                $currentDate = null;
                            @endphp
                            
                            @forelse($messages as $message)
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

                            <div class="d-flex mb-3 {{ $message->user_id == Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
                                {{-- Avatar pour les messages reçus (groupes) --}}
                                @if($message->user_id != Auth::id() && ($conversation->is_group ?? false))
                                    <div class="me-2">
                                        <img src="{{ $message->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($message->user->name ?? 'User') }}" 
                                             class="avatar-xs" alt="Avatar">
                                    </div>
                                @endif

                                <div class="message-bubble {{ $message->user_id == Auth::id() ? 'message-bubble-sent' : 'message-bubble-received' }}">
                                    {{-- Nom de l'expéditeur (groupes uniquement) --}}
                                    @if($message->user_id != Auth::id() && ($conversation->is_group ?? false))
                                        <div class="message-sender">{{ $message->user->name ?? 'Utilisateur' }}</div>
                                    @endif

                                    {{-- Pièce jointe --}}
                                    @if($message->attachment_path)
                                        <div class="attachment-display">
                                            @if($message->attachment_type == 'image')
                                                <a href="{{ $message->attachment_path }}" target="_blank" data-lightbox="message-{{ $message->id }}">
                                                    <img src="{{ $message->attachment_path }}" alt="Image" class="img-fluid">
                                                </a>
                                            @else
                                                @php
                                                    $extension = pathinfo($message->attachment_path, PATHINFO_EXTENSION);
                                                    $fileName = basename($message->attachment_path);
                                                    $iconClass = 'bx bx-file';
                                                    $iconColorClass = '';
                                                    
                                                    switch (strtolower($extension)) {
                                                        case 'pdf': $iconClass = 'bx bxs-file-pdf'; $iconColorClass = 'text-danger'; break;
                                                        case 'doc':
                                                        case 'docx': $iconClass = 'bx bxs-file-doc'; $iconColorClass = 'text-primary'; break;
                                                        case 'xls':
                                                        case 'xlsx': $iconClass = 'bx bxs-file'; $iconColorClass = 'text-success'; break;
                                                        case 'zip':
                                                        case 'rar': $iconClass = 'bx bxs-file-archive'; $iconColorClass = 'text-warning'; break;
                                                        case 'mp3':
                                                        case 'wav': $iconClass = 'bx bxs-music'; $iconColorClass = 'text-info'; break;
                                                        case 'mp4':
                                                        case 'mov': $iconClass = 'bx bxs-videos'; $iconColorClass = 'text-purple'; break;
                                                    }
                                                @endphp
                                                <a href="{{ $message->attachment_path }}" target="_blank" class="attachment-file">
                                                    <i class="{{ $iconClass }} fs-4 me-2 {{ $iconColorClass }}"></i>
                                                    <span>{{ Str::limit($fileName, 30) }}</span>
                                                </a>
                                            @endif
                                        </div>
                                    @endif

                                    {{-- Corps du message --}}
                                    @if($message->body)
                                        <p class="mb-0" style="white-space: pre-wrap;">{{ $message->body }}</p>
                                    @endif

                                    {{-- Heure --}}
                                    <div class="message-time text-end">
                                        {{ $message->created_at->format('H:i') }}
                                        @if($message->user_id == Auth::id())
                                            @if($message->is_read ?? false)
                                                <i class="bx bx-check-double"></i>
                                            @else
                                                <i class="bx bx-check"></i>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div>
                                    <i class="bx bx-message-alt-detail"></i>
                                    <h5 class="mt-3">Aucun message</h5>
                                    <p>Soyez le premier à envoyer un message dans cette conversation !</p>
                                </div>
                            </div>
                        @endforelse

                        {{-- Indicateur de saisie --}}
                        <div class="typing-indicator" id="typingIndicator">
                            <div class="typing-dot"></div>
                            <div class="typing-dot"></div>
                            <div class="typing-dot"></div>
                        </div>
                    </div>

                    {{-- Zone de saisie --}}
                    <div class="message-input-area">
                        {{-- Prévisualisation du fichier --}}
                        <div id="filePreview" class="d-none">
                            <div class="file-preview-container">
                                <div class="file-preview-item" id="filePreviewContent">
                                    <i class="bx bx-file fs-4 me-2 text-primary"></i>
                                    <span class="flex-grow-1" id="fileName"></span>
                                    <span class="remove-file" id="removeFile">×</span>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('messages.store', $conversation) }}" method="POST" enctype="multipart/form-data" id="messageForm">
                            @csrf
                            <div class="input-group-custom">
                                <button type="button" class="btn btn-light btn-icon" title="Joindre un fichier" id="attachmentButton">
                                    <i class="bx bx-paperclip"></i>
                                </button>
                                <input type="file" name="attachment" id="attachmentInput" class="d-none" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip,.rar">
                                
                                <input type="text" name="body" class="form-control message-input" 
                                       placeholder="Écrivez votre message..." id="messageInput" autocomplete="off">
                                
                                <button type="button" class="btn btn-light btn-icon d-none" title="Emoji" id="emojiButton">
                                    <i class="bx bx-smile"></i>
                                </button>
                                
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bx bx-send"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-scroll vers le bas
    const messagesContainer = document.getElementById('messagesContainer');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Gestion du fichier joint
    const attachmentButton = document.getElementById('attachmentButton');
    const attachmentInput = document.getElementById('attachmentInput');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const removeFile = document.getElementById('removeFile');

    attachmentButton?.addEventListener('click', () => {
        attachmentInput?.click();
    });

    attachmentInput?.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            fileName.textContent = file.name;
            filePreview.classList.remove('d-none');
        }
    });

    removeFile?.addEventListener('click', function() {
        attachmentInput.value = '';
        filePreview.classList.add('d-none');
    });

    // Focus sur l'input
    const messageInput = document.getElementById('messageInput');
    messageInput?.focus();

    // Empêcher l'envoi de messages vides
    const messageForm = document.getElementById('messageForm');
    messageForm?.addEventListener('submit', function(e) {
        const messageText = messageInput?.value.trim();
        const hasFile = attachmentInput?.files.length > 0;
        
        if (!messageText && !hasFile) {
            e.preventDefault();
            messageInput?.focus();
            return false;
        }
    });

    // Raccourci Entrée pour envoyer
    messageInput?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            messageForm?.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
        }
    });

    // Recherche de conversations
    const searchInput = document.getElementById('searchConversations');
    searchInput?.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('.conversation-item').forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Marquer les messages comme lus (simulation)
    // Vous pouvez ajouter un appel AJAX ici pour marquer les messages comme lus
});
</script>
@endsection