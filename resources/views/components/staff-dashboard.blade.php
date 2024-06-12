<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Pending Expenses</div>

            <div class="card-bod p-0">
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
                    @forelse($pending_expenses as $expense)
                        <tr>
                            <td>{{ $expense->id }}</td>
                            <td>{{ $expense->description }}</td>
                            <td>${{ $expense->amount }}</td>
                            <td>{{ $expense->category }}</td>
                            <td>{{ $expense->global_status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No data found!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Approved Expenses</div>

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
                    @forelse($approved_expenses as $expense)
                        <tr>
                            <td>{{ $expense->id }}</td>
                            <td>{{ $expense->description }}</td>
                            <td>${{ $expense->amount }}</td>
                            <td>{{ $expense->category }}</td>
                            <td>{{ $expense->global_status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No data found!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
