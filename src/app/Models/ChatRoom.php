<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = ['purchase_id'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}
