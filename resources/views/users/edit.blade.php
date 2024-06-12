@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2>Edit User: {{ $user->name }}</h2>

            <a href="{{ route('users.index') }}" class="btn btn-primary">
                Go Back
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('users.update', $user) }}" method="post">
                    @csrf
                    @method('PUT')

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

                        @if(auth()->user()->position === 'HEAD OF DEPARTMENT')
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
                        @else
                            <div class="col-md-6 mb-3">
                                <label for="department_id" class="form-label">Department</label>
                                <select
                                    id="department_id"
                                    name="department_id"
                                    required
                                    class="form-select @error('department_id')  is-invalid @enderror"
                                >
                                    <option value="">Choose one...</option>
                                    @foreach($departments as $department)
                                        <option
                                            value="{{ $department->id }}"
                                            {{ $user->department_id === $department->id ? 'selected' : '' }}
                                        >
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="col-md-6 mb-3">
                            <label for="position" class="form-label">Position</label>
                            <select
                                id="position"
                                name="position"
                                required
                                class="form-select @error('position') is-invalid @enderror"
                            >
                                <option value="">Choose one...</option>
                                @foreach($positions as $position)
                                    <option
                                        value="{{ $position }}"
                                        {{ $position === $user->position ? 'selected' : '' }}
                                    >
                                        {{ Str::title($position) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update User</button>
                </form>
            </div>
        </div>
    </div>
@endsection
