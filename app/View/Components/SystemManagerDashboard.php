<?php

namespace App\View\Components;

use App\Models\Department;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\Component;

class SystemManagerDashboard extends Component
{
    public array $count;

    public function __construct()
    {
        $this->count = [
            'total_users'       => User::query()->count(),
            'total_staff'       => User::query()->where('position', 'STAFF')->count(),
            'total_managers'    => User::query()->where('position', 'MANAGER')->count(),
            'total_hod'         => User::query()->where('position', 'HEAD OF DEPARTMENT')->count(),
            'total_departments' => Department::query()->count(),

            'expenses' => [
                'total'    => Expense::query()->count(),
                'pending'  => Expense::query()
                    ->where(function(Builder $query) {
                        $query->where('status_hod', 'Submitted')
                            ->orWhere('status_manager', 'Submitted');
                    })
                    ->where('is_active', true)
                    ->count(),
                'approved' => Expense::query()
                    ->where('status_manager', 'Approved')
                    ->where('status_hod', 'Approved')
                    ->count(),
                'rejected' => Expense::query()
                    ->where('status_hod', 'Rejected')
                    ->orWhere('status_manager', 'Rejected')
                    ->count(),
                'draft'    => Expense::query()
                    ->where('is_active', false)
                    ->count(),
            ],
        ];
    }

    public function render(): View
    {
        return view('components.system-manager-dashboard');
    }
}
