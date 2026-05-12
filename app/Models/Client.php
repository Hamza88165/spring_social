<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * Fields that can be mass-assigned (filled by create() / update()).
     * Laravel blocks everything else by default for security.
     */
    protected $fillable = [
        'name',
        'logo',
        'industry',
        'notes',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    /**
     * A client has many social accounts (Facebook / Instagram pages).
     */
    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * A client has many posts (through social accounts).
     * We keep a direct client_id on Post as well (per your schema).
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * A client can have many generated PDF reports.
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Returns the public URL of the logo, or a placeholder if none uploaded.
     * Call it anywhere: $client->logoUrl()
     */
    public function logoUrl(): string
    {
        if ($this->logo && file_exists(public_path('storage/' . $this->logo))) {
            return asset('storage/' . $this->logo);
        }

        // Fallback: first letter avatar via UI Avatars API
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name)
             . '&background=0f172a&color=f59e0b&bold=true&size=128';
    }

    /**
     * A list of industries used in dropdowns.
     * Static so you can call Client::industries() without an instance.
     */
    public static function industries(): array
    {
        return [
            'E-commerce',
            'Restaurant & Food',
            'Healthcare',
            'Real Estate',
            'Fashion & Retail',
            'Education',
            'Technology',
            'Hospitality & Tourism',
            'Beauty & Wellness',
            'Automotive',
            'Finance',
            'NGO / Non-profit',
            'Other',
        ];
    }
}