@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2>All Expenses</h2>

            <div>
                @if(!auth()->user()->isHeadOfDepartment() && !auth()->user()->isSystemManager())
                    <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                        Submit Expense
                    </a>
                @endif
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    @if(!auth()->user()->isStaff())
                        <th>Submitted By</th>
                    @endif
                    <th>Expense Description</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($expenses as $expense)
                    <tr>
                        <td>{{ $expense->id }}</td>
                        @if(!auth()->user()->isStaff())
                            <td>{{ $expense->user->name }}</td>
                        @endif
                        <td>{{ $expense->description }}</td>
                        <td>${{ $expense->amount }}</td>
                        <td>{{ $expense->global_status }}</td>
                        <td>
                            @if(auth()->user()->canAccessExpense($expense))
                                <a class="btn btn-primary btn-sm" href="{{ route('expenses.show', $expense) }}">
                                    @if(auth()->id() === $expense->user_id)
                                        View
                                    @elseif(auth()->user()->isSystemManager())
                                        View Details & Manage
                                    @else
                                        Review
                                    @endif
                                </a>
                            @endif

                            @if(auth()->id() === $expense->user_id && $expense->canBeEdited())
                                <a class="btn btn-success btn-sm" href="{{ route('expenses.edit', $expense) }}">
                                    Edit

                                    @if($expense->is_active)
                                        and Re-submit
                                    @endif
                                </a>
                            @endif

                            @if($expense->canBeDeleted())
                                <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete({{ $expense->id }})">
                                    Delete
                                </button>

                                <form id="delete-{{ $expense->id }}" action="{{ route('expenses.destroy', $expense) }}"
                                      method="post">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ !auth()->user()->isStaff() ? 6 : 5 }}" class="text-center">No data found!</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>


        {{ $expenses->links() }}
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this expense?")) {
                document.getElementById("delete-" + id).submit();
            }
        }
    </script>
@endsection
