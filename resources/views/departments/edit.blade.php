@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2>Update Department: {{ $department->name }}</h2>

            <a href="{{ route('departments.index') }}" class="btn btn-primary">
                Go Back
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('departments.update', $department) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input
                            id="name"
                            class="form-control"
                            type="text"
                            name="name"
                            required
                            value="{{ old('name', $department->name) }}"
                        >

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Department</button>
                </form>
            </div>
        </div>
    </div>
@endsection
