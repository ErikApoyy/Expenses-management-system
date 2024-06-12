<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Rules\PasswordValidationRule;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $departments = Department::all();

        return view('profile.index', compact('user', 'departments'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'string', 'min:5', 'max:10', new PasswordValidationRule(), 'confirmed'],
        ]);

        auth()->user()->update([
            'password' => bcrypt($request->input('password')),
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Password has been updated.');
    }

    public function updateDepartment(Request $request)
    {
        $request->validate([
            'department_id' => ['required', 'exists:departments,id'],
        ]);

        // Check if that department already has a H.O.D
        if(auth()->user()->isHeadOfDepartment() && auth()->user()->department_id !== (int) $request->input('department_id')) {
            $another_hod = User::query()
                ->where('department_id', $request->input('department_id'))
                ->where('position', 'HEAD OF DEPARTMENT')
                ->exists();

            if($another_hod) {
                return redirect()->route('profile.index')
                    ->with('error', 'This department already has a H.O.D.');
            }
        }

        auth()->user()->update([
            'department_id' => $request->input('department_id'),
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Department has been updated.');
    }
}
