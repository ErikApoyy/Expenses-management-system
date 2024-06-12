<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $user = auth()->user();

        $query = Expense::query();

        // For Self
        if ($user->isStaff()) {
            $query = $query->where('user_id', auth()->id());
        }

        // For Manager
        if ($user->isManager()) {
            $query = $query->where('user_id', auth()->id())
                ->orWhereHas('user', function (Builder $query) {
                    $query->where('manager_id', auth()->id())
                        ->where('is_active', true);
                });
        }

        // For H.O.D
        if ($user->isHeadOfDepartment()) {
            $query = $query->whereHas('user', function (Builder $query) use ($user) {
                $query->where('department_id', $user->department_id)
                    ->where('is_active', true);
            });
        }

        $expenses = $query->orderBy('id', 'DESC')
            ->paginate(30);

        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $this->canSubmitExpense();

        $categories = Expense::CATEGORIES;

        return view('expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->canSubmitExpense();

        $data = $request->validate([
            'description' => ['required', 'max:255'],
            'amount'      => ['required', 'numeric', 'min:0'],
            'category'    => ['required', Rule::in(Expense::CATEGORIES)],
            'document'    => ['required', 'file', 'mimes:pdf,jpeg,png,gif'],
            'draft'       => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('documents', ['disk' => 'public']);
        }

        $data['user_id'] = auth()->id();

        if ($request->boolean('draft')) {
            $data['is_active'] = false;
        } else {
            $data['is_active'] = true;
        }

        if (auth()->user()->isManager()) {
            $data['status_manager'] = 'Approved';
        }

        Expense::create($data);

        return redirect()->route('expenses.index')
            ->with('success', 'Expense has been submitted.');
    }

    public function show(Expense $expense)
    {
        $this->checkIfExpenseCanBeViewed($expense);

        $statuses = Expense::STATUSES;

        return view('expenses.show', compact('expense', 'statuses'));
    }

    public function edit(Expense $expense)
    {
        $this->checkIfExpenseCanBeEdited($expense);

        $categories = Expense::CATEGORIES;

        return view('expenses.edit', compact('expense', 'categories'));
    }

    public function update(Request $request, Expense $expense)
    {
        $this->checkIfExpenseCanBeEdited($expense);

        $data = $request->validate([
            'description' => ['required', 'max:255'],
            'amount'      => ['required', 'numeric', 'min:0'],
            'category'    => ['required', Rule::in(Expense::CATEGORIES)],
            'document'    => ['nullable', 'file', 'mimes:pdf,jpeg,png,gif'],
            'draft'       => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('document')) {
            if ($expense->document && Storage::exists('public/'.$expense->document)) {
                Storage::delete('public/'.$expense->document);
            }

            $data['document'] = $request->file('document')->store('documents', ['disk' => 'public']);
        }

        if ($expense->is_active) {
            $data['status_hod']      = 'Submitted';
            $data['status_manager']  = 'Submitted';
            $data['remarks_hod']     = null;
            $data['remarks_manager'] = null;
        }

        if (auth()->user()->isManager()) {
            $data['status_manager'] = 'Approved';
        }

        if (!$request->boolean('draft')) {
            $data['is_active'] = true;
        }

        $expense->update($data);

        return redirect()->route('expenses.index')
            ->with('success', 'Expense has been updated successfully!');
    }

    public function approveManager(Request $request, Expense $expense)
    {
        $this->checkIfValidManagerForExpense($expense);

        if ($expense->status_manager !== 'Submitted') {
            return redirect()->route('expenses.show', $expense)
                ->with('success', 'This expense has already been processed.');
        }

        $data = $request->validate([
            'response' => ['nullable', 'max:255'],
        ]);

        $expense->update([
            'status_manager'   => 'Approved',
            'remarks_manager' => $data['response'],
        ]);

        return redirect()->route('expenses.show', $expense)
            ->with('success', 'Expense submission has been approved successfully!');
    }

    public function rejectManager(Request $request, Expense $expense)
    {
        $this->checkIfValidManagerForExpense($expense);

        if ($expense->status_manager !== 'Submitted') {
            return redirect()->route('expenses.index')
                ->with('success', 'This expense has already been processed.');
        }

        $data = $request->validate([
            'response' => ['required', 'max:255'],
        ]);

        $expense->update([
            'status_manager'   => 'Rejected',
            'remarks_manager' => $data['response'],
        ]);

        return redirect()->route('expenses.show', $expense)
            ->with('success', 'Expense submission has been rejected!');
    }

    public function approveHod(Request $request, Expense $expense)
    {
        $this->checkIfValidHodForExpense($expense);

        if ($expense->status_hod !== 'Submitted') {
            return redirect()->route('expenses.index')
                ->with('success', 'This expense has already been processed.');
        }

        $data = $request->validate([
            'response' => ['nullable', 'max:255'],
        ]);

        $expense->update([
            'status_hod'  => 'Approved',
            'remarks_hod' => $data['response'],
        ]);

        return redirect()->route('expenses.show', $expense)
            ->with('success', 'Expense submission has been approved successfully!');
    }

    public function rejectHod(Request $request, Expense $expense)
    {
        $this->checkIfValidHodForExpense($expense);

        if ($expense->status_hod !== 'Submitted') {
            return redirect()->route('expenses.index')
                ->with('success', 'This expense has already been processed.');
        }

        $data = $request->validate([
            'response' => ['required', 'max:255'],
        ]);

        $expense->update([
            'status_hod'  => 'Rejected',
            'remarks_hod' => $data['response'],
        ]);

        return redirect()->route('expenses.show', $expense)
            ->with('success', 'Expense submission has been rejected!');
    }

    public function destroy(Expense $expense)
    {
        if (!$expense->canBeDeleted()) {
            abort(403, 'This expense cannot be deleted.');
        }

        // Delete document if any
        if($expense->document && Storage::exists('public/'.$expense->document)) {
            Storage::delete('public/'.$expense->document);
        }

        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'Expense has been deleted successfully!');
    }

    public function updateStatus(Request $request, Expense $expense)
    {
        if (!auth()->user()->isSystemManager()) {
            abort(403, 'You are not allowed to change the status of this expense.');
        }

        $data = $request->validate([
            'status_hod'  => ['required', Rule::in(Expense::STATUSES)],
            'remarks_hod' => ['nullable', 'string', 'max:254'],
        ]);

        $expense->update([
            'status_hod'  => $data['status_hod'],
            'remarks_hod' => $data['remarks_hod'],
        ]);

        return redirect()->route('expenses.show', $expense)
            ->with('success', 'Expense status has been updated successfully!');
    }

    private function canSubmitExpense()
    {
        $user = auth()->user();

        if ($user->isHeadOfDepartment() || $user->isSystemManager()) {
            abort(403, 'You are not allowed to submit expenses.');
        }
    }

    private function checkIfValidManagerForExpense(Expense $expense)
    {
        if (auth()->user()?->position !== 'MANAGER') {
            abort(403, 'You are not a manager.');
        }

        if (auth()->id() !== $expense->user?->manager_id) {
            abort(403, 'You are not the manager for this expense.');
        }
    }

    private function checkIfValidHodForExpense(Expense $expense)
    {
        if ($expense->status_manager !== 'Approved') {
            abort(403, 'This expense has not been approved by the manager.');
        }

        if (auth()->user()?->position !== 'HEAD OF DEPARTMENT') {
            abort(403, 'You are not a manager.');
        }

        if (auth()->user()->department_id !== $expense->user->department_id) {
            abort(403, 'You do not have access to this expense as it is not from your department.');
        }
    }

    private function checkIfExpenseCanBeViewed(Expense $expense)
    {
        if (auth()->user()->canAccessExpense($expense)) {
            return;
        }

        abort(403, 'You do not have access to this expense.');
    }

    private function checkIfExpenseCanBeEdited(Expense $expense)
    {
        if (!$expense->canBeEdited()) {
            abort(403, 'This expense cannot be edited.');
        }

        if ($expense->user_id !== auth()->id()) {
            abort(403, 'You do not have access to this expense.');
        }
    }
}
