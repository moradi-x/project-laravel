<?php

namespace App\Models;


use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'family',
        'status',
        'role',
        'avatar',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        // برای تبدیل داده ای 
        'password' => 'hashed',
        'role' => UserRoleEnum::class,
        'status' => 'boolean'
    ];

    protected function FullName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->name . ' ' . $this->family
        );
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function isAdmin()
    {
        return $this->role == UserRoleEnum::ADMIN;
    }

    public function isUser()
    {
        return $this->role == UserRoleEnum::USER;
    }
}
