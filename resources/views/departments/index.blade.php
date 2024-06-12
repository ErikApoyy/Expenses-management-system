@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2>Departments</h2>

            <a href="{{ route('departments.create') }}" class="btn btn-primary">
                Add New Department
            </a>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Head of Department</th>
                <th>Staffs Associated</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach($departments as $department)
                <tr>
                    <td>
                        {{ $department->id }}
                    </td>
                    <td>
                        {{ $department->name }}
                    </td>
                    <td>
                        @if($department->headOfDepartment)
                            {{ $department->headOfDepartment->name }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        {{ $department->users_count }}
                    </td>
                    <td>
                        <a href="{{ route('departments.edit', $department) }}" class="btn btn-primary btn-sm">
                            Edit
                        </a>

                        @if($department->users_count === 0)
                            <button onclick="confirmDelete({{ $department->id }})" class="btn btn-danger btn-sm">
                                Delete
                            </button>

                            <form method="POST" class="d-none" id="delete-{{ $department->id }}"
                                  action="{{ route('departments.destroy', $department->id) }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        @else
                            <button
                                type="button"
                                class="btn btn-danger btn-sm"
                                onclick="showCannotDelete()"
                            >
                                Delete
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this department?")) {
                document.getElementById("delete-" + id).submit();
            }
        }

        function showCannotDelete() {
            alert('Sorry, department cannot be deleted as it has staffs associated with it.');
        }
    </script>
@endsection
