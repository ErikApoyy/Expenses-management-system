@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2>Assign Manager to Staff: {{ $user->name }}</h2>

            <a href="{{ route('users.index') }}" class="btn btn-primary">
                Go Back
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('users.assign-manager', $user) }}" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input
                                id="name"
                                class="form-control"
                                type="text"
                                value="{{ $user->name }}"
                                disabled
                            >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input
                                id="email"
                                class="form-control"
                                type="text"
                                value="{{ $user->email }}"
                                disabled
                            >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="department" class="form-label">Department</label>
                            <input
                                id="department"
                                class="form-control"
                                type="text"
                                value="{{ $user->department?->name }}"
                                disabled
                            >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="position" class="form-label">Position</label>
                            <input
                                id="position"
                                class="form-control"
                                type="text"
                                value="{{ Str::title($user->position) }}"
                                disabled
                            >
                        </div>


                        <div class="col-md-12 mb-3">
                            <label for="manager_id" class="form-label">Manager</label>
                            <select
                                id="manager_id"
                                name="manager_id"
                                required
                                class="form-select @error('position') is-invalid @enderror"
                            >
                                <option value="">Choose one...</option>
                                @foreach($managers as $manager)
                                    <option
                                        value="{{ $manager->id }}"
                                        {{ $user->manager_id === $manager->id ? 'selected' : '' }}
                                    >
                                        {{ $manager->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Manager</button>
                </form>
            </div>
        </div>
    </div>
@endsection
