<div>
    <div class="card mb-3">
        <div class="card-header">
            Expenses Awaiting Your Review
        </div>
        <div class="card-body p-0">
            <table class="table m-0 table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Added By</th>
                    <th>Expense Description</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($pending_to_review as $expense)
                    <tr>
                        <td>{{ $expense->id }}</td>
                        <td>{{ $expense->user?->name }}</td>
                        <td>{{ $expense->description }}</td>
                        <td>{{ $expense->category }}</td>
                        <td>${{ $expense->amount }}</td>
                        <td>{{ $expense->global_status }}</td>
                        <td>
                            <a href="{{ route('expenses.show', $expense) }}" class="btn btn-primary btn-sm">
                                Review
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No data found!</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $pending_to_review->links() }}
        </div>
    </div>


    <h3 class="text-center my-3">Stats</h3>

    <div class="row">
        <div class="col-md-4">
            <div class="card card-body  bg-primary bg-opacity-10 shadow-sm mb-4">
                <h1 class="text-primary">
                    {{ $count['total_expenses'] }}
                </h1>
                <h6 class="mb-0">Total Count of Expenses in the Department</h6>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-body  bg-warning bg-opacity-10 shadow-sm mb-4">
                <h1 class="text-warning">
                    {{ $count['total_staff'] }}
                </h1>
                <h6 class="mb-0">Total Staff In the Department</h6>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-body  bg-success bg-opacity-10 shadow-sm mb-4">
                <h1 class="text-success">
                    {{ $count['total_managers'] }}
                </h1>
                <h6 class="mb-0">Total Managers In the Department</h6>
            </div>
        </div>
    </div>
</div>
