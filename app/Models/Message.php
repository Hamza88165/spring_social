<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'social_account_id',
        'sender_name',
        'sender_id',
        'content',
        'type',
        'post_id',
        'is_read',
        'replied_at',
        'created_at',
    ];

    protected $casts = [
        'is_read'    => 'boolean',
        'replied_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function socialAccount()
    {
        return $this->belongsTo(SocialAccount::class);
    }

    public function reply()
    {
        return $this->hasOne(Reply::class);
    }
}