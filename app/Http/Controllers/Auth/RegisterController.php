<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Rules\PasswordValidationRule;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $department_id = $data['department_id'] ?? null;
        $position      = $data['position'] ?? null;

        /**
         * Check if there is already a HOD for the department.
         * If there is, throw an error.
         */
        if ($position === 'HEAD OF DEPARTMENT' && $department_id) {
            $check = User::query()
                ->where('department_id', $department_id)
                ->where('position', $position)
                ->exists();

            if ($check) {
                throw ValidationException::withMessages([
                    'position' => 'There is already a HOD for this department.',
                ]);
            }
        }

        /**
         * List of available positions.
         */
        $positions = [
            'STAFF',
            'MANAGER',
            'HEAD OF DEPARTMENT',
        ];

        return Validator::make($data, [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'      => ['required', 'string', 'min:5', 'max:10', 'confirmed', new PasswordValidationRule()],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'position'      => ['required', 'string', 'max:255', Rule::in($positions)],
        ], [
            'password' => 'The password must be 5-10 characters long and contain at least 2 uppercase letters, 1 number, and 1 special character.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'       => $data['name'],
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
            'department' => $data['department_id'],
            'position'   => $data['position'],
        ]);
    }
}
