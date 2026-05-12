<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'client_id',
        'user_id',
        'period_start',
        'period_end',
        'generated_at',
        'file_path',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end'   => 'date',
        'generated_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}