<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    /**
     * Store a newly created message in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Conversation $conversation)
    {
        // TODO: Add authorization to check if Auth::user() can post in this conversation.

        $request->validate([
            'body' => 'nullable|string|required_without:attachment',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,mp4,mov,avi,mp3,wav|max:20480', // 20MB Max
        ]);

        $attachmentPath = null;
        $attachmentType = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            // Store the file in a conversation-specific folder
            $path = $file->store('public/message_attachments/' . $conversation->id);
            $attachmentPath = Storage::url($path);
            
            // Determine file type
            $mime = $file->getMimeType();
            if (str_starts_with($mime, 'image/')) {
                $attachmentType = 'image';
            } elseif (str_starts_with($mime, 'video/')) {
                $attachmentType = 'video';
            } elseif (str_starts_with($mime, 'audio/')) {
                $attachmentType = 'audio';
            } else {
                $attachmentType = 'file';
            }
        }

        $conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
            'attachment_path' => $attachmentPath,
            'attachment_type' => $attachmentType,
        ]);
        
        // Also update the conversation's updated_at timestamp to bring it to the top of the list.
        $conversation->touch();

        return redirect()->route('conversations.show', $conversation);
    }
}
