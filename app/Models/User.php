<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'full_name',
        'email',
        'password',
        'type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function isAdmin()
    {
        return $this->type === 'admin';
    }

    public function isEmployee()
    {
        return $this->type === 'employee';
    }
}