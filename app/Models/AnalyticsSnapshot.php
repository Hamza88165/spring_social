<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsSnapshot extends Model
{
    protected $fillable = [
        'social_account_id',
        'date',
        'followers_count',
        'reach',
        'impressions',
        'engagement_rate',
        'posts_count',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function socialAccount()
    {
        return $this->belongsTo(SocialAccount::class);
    }
}