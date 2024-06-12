<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = [
        'user_id', 'description', 'amount', 'category', 'document', 'is_active', 'status_manager',
        'remarks_manager', 'status_hod', 'remarks_hod',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public const CATEGORIES = [
        'Overtime Meal',
        'Business Travel',
        'Office Expenses',
        'Education',
        'Health',
        'Other',
    ];

    public const STATUSES = [
        'Submitted',
        'Approved',
        'Rejected',
    ];

    public function isManager(User $user): bool
    {
        return $this->user->manager_id === $user->id;
    }

    public function isHod(User $user): bool
    {
        return $user->isHeadOfDepartment() && $this->user->department_id === $user->department_id;
    }

    public function getGlobalStatusAttribute(): string
    {
        if (!$this->is_active) {
            return "Draft";
        }

        if ($this->status_manager === 'Submitted') {
            return "Pending";
        } elseif ($this->status_hod === 'Rejected') {
            return "Rejected by H.O.D";
        } elseif ($this->status_hod === 'Approved') {
            return "Approved";
        } elseif ($this->status_manager === 'Approved') {
            return "Pending Review by H.O.D";
        } elseif ($this->status_manager === 'Rejected') {
            return "Rejected by Manager";
        }

        return $this->status;
    }

    public function canBeEdited(): bool
    {
        if ($this->id !== auth()->id()) {
            return false;
        }

        if (!$this->is_active && $this->id === auth()->id()) {
            return true;
        }

        // If is manager, they can edit if the status is submitted.
        if (auth()->user()->isManager() && $this->status_hod !== 'Approved') {
            return true;
        }

        if ($this->status_manager === 'Submitted') {
            return true;
        }

        return $this->status_hod === 'Rejected' || $this->status_manager === 'Rejected';
    }

    public function canBeDeleted(): bool
    {
        if (auth()->user()->isSystemManager()) {
            return true;
        }

        return false;
    }
}
