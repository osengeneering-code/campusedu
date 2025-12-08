<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use App\Services\MessagingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    protected $messagingService;

    public function __construct(MessagingService $messagingService)
    {
        $this->messagingService = $messagingService;
    }

    public function index()
    {
        $user = Auth::user();
        $conversations = $user->conversations()->with(['participants', 'lastMessage.user'])->latest('updated_at')->get();
        
        return view('conversations.index', compact('conversations'));
    }

    public function create()
    {
        $users = $this->messagingService->getPotentialRecipients(Auth::user());
        return view('conversations.create', compact('users'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $type = $request->input('type', 'direct'); // 'direct' from the new view

        if ($type === 'direct') {
            $validated = $request->validate([
                'users' => 'required|array|min:1',
                'users.*' => 'exists:users,id',
            ]);
            // For a direct chat, we take the first selected user
            $recipient = User::findOrFail($validated['users'][0]);
            $conversation = $this->messagingService->getOrCreatePrivateConversation($user, $recipient);
        } else { // 'group'
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'users' => 'required|array|min:1',
                'users.*' => 'exists:users,id',
            ]);
            $conversation = $this->messagingService->createGroupConversation($user, $validated['users'], $validated['name']);
        }

        return redirect()->route('conversations.show', $conversation);
    }

    public function show(Conversation $conversation)
    {
        // TODO: Add authorization check to ensure user is part of this conversation
        $conversation->load('participants');
        
        $messages = $conversation->messages()->latest()->get();

        $user = Auth::user();
        $allConversations = $user->conversations()->with(['participants', 'lastMessage.user'])->latest('updated_at')->get();

        return view('conversations.show', compact('conversation', 'messages', 'allConversations'));
    }
}
