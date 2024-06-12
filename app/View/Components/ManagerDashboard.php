<?php

namespace App\View\Components;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ManagerDashboard extends Component
{
    public $pending_own;
    public $approved_own;
    public $pending_to_review;

    public function __construct()
    {
        $this->pending_to_review = Expense::query()
            ->where('user_id', User::query()->where('manager_id', auth()->id())->pluck('id')->toArray())
            ->where('status_manager', 'Submitted')
            ->orderBy('id', 'DESC')
            ->where('is_active', true)
            ->paginate(10);

        $this->pending_own = Expense::query()
            ->where('user_id', auth()->id())
            ->where('status_hod', 'Submitted')
            ->orderBy('id', 'DESC')
            ->paginate(10);

        $this->approved_own = Expense::query()
            ->where('user_id', auth()->id())
            ->where('status_hod', 'Approved')
            ->orderBy('id', 'DESC')
            ->paginate(10);
    }

    public function render(): View
    {
        return view('components.manager-dashboard');
    }
}
