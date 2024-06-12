<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can-manage-user']);
    }

    public function index()
    {
        $users = User::query()
            ->when(auth()->user()->position === 'HEAD OF DEPARTMENT', function (Builder $query) {
                $query->where('department_id', auth()->user()->department_id)
                    ->where('position', '<>', 'HEAD OF DEPARTMENT');
            })
            ->with(['department', 'manager'])
            ->where('id', '<>', auth()->id())
            ->get();

        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        if (auth()->user()->isSystemManager()) {
            $positions = User::POSITIONS;
        } else {
            $positions = [
                'STAFF',
                'MANAGER',
            ];
        }

        $departments = Department::get();

        return view('users.edit', compact('user', 'positions', 'departments'));
    }

    public function assignManager(User $user)
    {
        $this->canAssignManager($user);

        $managers = User::query()
            ->where('department_id', $user->department_id)
            ->where('position', 'MANAGER')
            ->get();

        return view('users.assign-manager', compact('user', 'managers'));
    }

    public function updateManager(Request $request, User $user)
    {
        $this->canAssignManager($user);

        $request->validate([
            'manager_id' => ['required', 'exists:users,id'],
        ]);

        // Check if manager is from same department
        $manager = User::query()
            ->where('id', $request->input('manager_id'))
            ->where('department_id', $user->department_id)
            ->where('position', 'MANAGER')
            ->first();

        if (!$manager) {
            throw ValidationException::withMessages([
                'manager_id' => 'The selected manager is not from the same department or is not a manager.',
            ]);
        }

        $user->update([
            'manager_id' => $request->input('manager_id'),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Manager has been assigned.');
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'position' => ['required', Rule::in(User::POSITIONS)],
        ];

        if (auth()->user()->isSystemManager()) {
            $rules['department_id'] = ['required', 'exists:departments,id'];
        }

        $data = $request->validate($rules);

        $department_roles = ['STAFF', 'MANAGER', 'HEAD OF DEPARTMENT'];

        // If we do not have department_id and the role is one of the department roles, throw an error.

        if (in_array($request->input('role'), $department_roles) && !$request->input('department_id')) {
            throw ValidationException::withMessages([
                'department_id' => 'The department field is required.',
            ]);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'User has been updated.');
    }

    private function canAssignManager(User $user)
    {
        if (!$user->isStaff()) {
            abort(403, 'You can only assign manager to staff.');
        }

        if (!auth()->user()->isSystemManager() && !auth()->user()->isHeadOfDepartment()) {
            abort(403, 'You are not allowed to assign manager.');
        }
    }
}
