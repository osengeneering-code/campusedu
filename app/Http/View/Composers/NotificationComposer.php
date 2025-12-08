<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class NotificationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Get IDs of conversations the user is in
            $conversationIds = $user->conversations->pluck('id');

            // Get unread messages count
            $unreadMessagesCount = Message::whereIn('conversation_id', $conversationIds)
                ->where('user_id', '!=', $user->id)
                ->whereNull('read_at')
                ->count();

            // Get recent unread messages (e.g., last 5)
            $recentUnreadMessages = Message::whereIn('conversation_id', $conversationIds)
                ->where('user_id', '!=', $user->id)
                ->whereNull('read_at')
                ->with('user', 'conversation') // Eager load sender and conversation info
                ->latest()
                ->take(5)
                ->get();
        } else {
            $unreadMessagesCount = 0;
            $recentUnreadMessages = collect();
        }

        $view->with('unreadMessagesCount', $unreadMessagesCount);
        $view->with('recentUnreadMessages', $recentUnreadMessages);
    }
}
