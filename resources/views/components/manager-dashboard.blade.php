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
                        <td>{{ $expense->status_manager }}</td>
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

    <h3 class="text-center mb-3">Your Expense Reports</h3>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Your Pending Expenses
                </div>
                <div class="card-body p-0">
                    <table class="table m-0 table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Expense Description</th>
                            <th>Amount</th>
                            <th>Category</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($pending_own as $expense)
                            <tr>
                                <td>{{ $expense->id }}</td>
                                <td>{{ $expense->description }}</td>
                                <td>${{ $expense->amount }}</td>
                                <td>${{ $expense->category }}</td>
                                <td>{{ $expense->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No data found!</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $pending_own->links() }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Your Approved Expenses
                </div>
                <div class="card-body p-0">
                    <table class="table m-0 table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Expense Description</th>
                            <th>Amount</th>
                            <th>Category</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($approved_own as $expense)
                            <tr>
                                <td>{{ $expense->id }}</td>
                                <td>{{ $expense->description }}</td>
                                <td>${{ $expense->amount }}</td>
                                <td>{{ $expense->category }}</td>
                                <td>{{ $expense->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No data found!</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $approved_own->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
