@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2>Add New Department</h2>

            <a href="{{ route('departments.index') }}" class="btn btn-primary">
                Go Back
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('departments.store') }}" method="post">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            type="text"
                            name="name"
                            required
                            value="{{ old('name') }}"
                        >

                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Add New Department</button>
                </form>
            </div>
        </div>
    </div>
@endsection
