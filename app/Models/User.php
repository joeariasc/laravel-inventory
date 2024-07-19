<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Traits\Uuids;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Uuids, SoftDeletes;

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'role',
        'name',
        'last_name',
        'personal_id',
        'email',
        'password',
        'store_name',
        'store_address',
        'store_phone',
        'store_email',
        'photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'role' => UserRole::class,
    ];

    public function fullName(): string
    {
        return $this->name . " " . $this->last_name;
    }

    public function pathAttachment(): string
    {
        return $this->photo ? "/images/users/" . $this->photo : "/images/default/default_user.png";
    }

    public function scopeSearch($query, $value): void
    {
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('last_name', 'like', "%{$value}%")
            ->orWhere('personal_id', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%");
    }
}
