<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Message;
use App\Models\Module;
use App\Models\Filiere;
use App\Models\Stage;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'module_id',
        'filiere_id',
        'stage_id',
    ];

    /**
     * The participants that belong to the conversation.
     */
    public function participants()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * The messages for the conversation.
     */
    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get the last message for the conversation.
     */
    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    /**
     * Accessor to get the other user in a private conversation.
     */
    public function getOtherUserAttribute()
    {
        if ($this->type !== 'private') {
            return null;
        }

        // Note: This requires the 'participants' relationship to be loaded.
        return $this->participants->firstWhere('id', '!=', Auth::id());
    }

    /**
     * Accessor to check if the conversation is a group chat.
     */
    public function getIsGroupAttribute()
    {
        return $this->type === 'group' || $this->type === 'forum';
    }


    // Relationships for automatic groups
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }
   public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_user', 'conversation_id', 'user_id')
                    ->withTimestamps();
    }


    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
