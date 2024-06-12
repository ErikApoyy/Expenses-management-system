<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'email_verified_at', 'password', 'position', 'department_id', 'manager_id', 'role',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public const POSITIONS = [
        'STAFF',
        'MANAGER',
        'HEAD OF DEPARTMENT',
        'SYSTEM MANAGER',
    ];

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'user_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function canEditUsers(): bool
    {
        return $this->position === 'SYSTEM MANAGER' || $this->position === 'HEAD OF DEPARTMENT';
    }

    public function canEditExpenses(): bool
    {
        return $this->position === 'STAFF' || $this->position === 'MANAGER';
    }

    public function isSystemManager(): bool
    {
        return $this->position === 'SYSTEM MANAGER';
    }

    public function isStaff(): bool
    {
        return $this->position === 'STAFF';
    }

    public function isManager(): bool
    {
        return $this->position === 'MANAGER';
    }

    public function isHeadOfDepartment(): bool
    {
        return $this->position === 'HEAD OF DEPARTMENT';
    }

    public function canAccessExpense(Expense $expense): bool
    {
        if ($this->id === $expense->user_id) {
            return true;
        }

        if ($this->id === $expense->user?->manager_id) {
            return true;
        }

        if ($this->isSystemManager()) {
            return true;
        }

        if ($this->position === 'HEAD OF DEPARTMENT' && $this->department_id === $expense->user?->department_id) {
            return true;
        }

        return false;
    }
}
