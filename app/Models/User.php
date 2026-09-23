<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'school_id',
        'name',
        'email',
        'role_name',
        'phone',
        'photo',
        'status',
        'last_login_at',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function hasRole($roleSlug)
    {
        if ($this->role_name === $roleSlug) {
            return true;
        }
        return $this->roles->contains('slug', $roleSlug);
    }

    public function hasPermissionTo($permissionSlug)
    {
        if ($this->role_name === 'super_admin' || $this->role_name === 'school_admin') {
            return true;
        }

        foreach ($this->roles as $role) {
            if ($role->permissions->contains('slug', $permissionSlug)) {
                return true;
            }
        }
        return false;
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function parentProfile()
    {
        return $this->hasOne(ParentObject::class, 'user_id');
    }
}
