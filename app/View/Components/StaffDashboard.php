<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\Component;

class StaffDashboard extends Component
{
    public $pending_expenses;
    public $approved_expenses;

    public function __construct()
    {
        $this->pending_expenses = auth()->user()->expenses()
            ->where('is_active', true)
            ->where(function(Builder $query) {
                $query->where('status_manager', 'Submitted')
                    ->orWhere('status_hod', 'Submitted');
            })
            ->paginate(30);

        $this->approved_expenses = auth()->user()->expenses()
            ->where('is_active', true)
            ->where('status_manager', 'Approved')
            ->where('status_hod', 'Approved')
            ->paginate(30);
    }

    public function render(): View
    {
        return view('components.staff-dashboard');
    }
}
