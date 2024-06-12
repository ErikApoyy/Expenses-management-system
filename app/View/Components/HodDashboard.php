<?php

namespace App\View\Components;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\Component;

class HodDashboard extends Component
{
    public array $count;
    public $pending_to_review;

    public function __construct()
    {
        $this->pending_to_review = Expense::query()
            ->whereHas('user', function (Builder $query) {
                $query->where('department_id', auth()->user()->department_id);
            })
            ->where('is_active', true)
            ->where('status_manager', 'Approved')
            ->where('status_hod', 'Submitted')
            ->paginate(10);

        $this->count = [
            'total_staff'    => auth()->user()->department->users()->where('position', 'STAFF')->count(),
            'total_managers' => auth()->user()->department->users()->where('position', 'MANAGER')->count(),
            'total_expenses' => Expense::query()
                ->whereHas('user', function (Builder $query) {
                    $query->where('department_id', auth()->user()->department_id);
                })
                ->where('is_active', true)
                ->count(),
        ];
    }

    public function render()
    {
        return view('components.hod-dashboard');
    }
}
