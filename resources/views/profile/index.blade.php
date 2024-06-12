@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2>Profile: {{ $user->name }}</h2>
        </div>

        <div class="card card-body p-0 mb-3">
            <table class="table table-bordered m-0">
                <tr>
                    <th style="width: 150px">Name</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                @if($user->department_id)
                    <tr>
                        <th>Department</th>
                        <td>{{ $user->department?->name }}</td>
                    </tr>
                @endif
                <tr>
                    <th>Position</th>
                    <td>{{ $user->position }}</td>
                </tr>
            </table>

        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Update Password
                    </div>

                    <div class="card-body">
                        <form action="{{ route('profile.password') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" name="current_password" id="current_password"
                                       class="form-control @error('current_password') is-invalid @enderror">

                                @error('current_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" name="password" id="password"
                                       class="form-control @error('password') is-invalid @enderror">

                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Password Confirmation -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="form-control @error('password_confirmation') is-invalid @enderror">

                                @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <button class="btn btn-primary">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>

            @if($user->position !== 'SYSTEM MANAGER')
                <!-- Change Department -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Change Department
                        </div>

                        <div class="card-body">
                            <form action="{{ route('profile.department') }}" method="post">
                                @csrf

                                <!-- Department -->
                                <div class="mb-3">
                                    <label for="department" class="form-label">Department</label>
                                    <select name="department_id" id="department"
                                            class="form-select @error('department') is-invalid @enderror">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}"
                                                    @if($department->id === auth()->user()->department_id) selected @endif>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('department')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <button class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection
