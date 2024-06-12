@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2>All Users</h2>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Position</th>
                <th>Manager</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->department?->name }}</td>
                    <td>{{ Str::title($user->position) }}</td>
                    <td>
                        @if($user->manager)
                            {{ $user->manager->name }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-sm">
                            Edit
                        </a>

                        @if($user->position === 'STAFF')
                            <a href="{{ route('users.assign-manager', $user) }}" class="btn btn-secondary btn-sm">
                                Assign Manager
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
