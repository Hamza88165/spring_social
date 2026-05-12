<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    protected $fillable = [
        'client_id',
        'platform',
        'page_id',
        'page_name',
        'access_token',
        'token_expires_at',
    ];

    protected $casts = [
        'token_expires_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function analyticsSnapshots()
    {
        return $this->hasMany(AnalyticsSnapshot::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}