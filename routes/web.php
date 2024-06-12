<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\MainPageController::class, 'index'])->name('index');

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('profile/department', [ProfileController::class, 'updateDepartment'])->name('profile.department');

    Route::post('expenses/{expense}/update-status', [ExpenseController::class, 'updateStatus'])
        ->name('expenses.update-status');

    Route::post('expenses/{expense}/approve-manager', [ExpenseController::class, 'approveManager'])
        ->name('expenses.approve-manager');
    Route::post('expenses/{expense}/reject-manager', [ExpenseController::class, 'rejectManager'])
        ->name('expenses.reject-manager');

    Route::post('expenses/{expense}/approve-hod', [ExpenseController::class, 'approveHod'])
        ->name('expenses.approve-hod');
    Route::post('expenses/{expense}/reject-hod', [ExpenseController::class, 'rejectHod'])
        ->name('expenses.reject-hod');

    // General Expense CRUD
    Route::resource('expenses', ExpenseController::class);

    // System Manager Routes
    Route::get('users/{user}/assign-manager', [UserController::class, 'assignManager'])->name('users.assign-manager');
    Route::post('users/{user}/assign-manager', [UserController::class, 'updateManager'])->name('users.update-manager');

    Route::resource('users', UserController::class)
        ->only(['index', 'edit', 'update']);
    Route::resource('departments', DepartmentController::class);
});
