<div class="row">
    <div class="col-md-3">
        <div class="card card-body  bg-primary bg-opacity-10 shadow-sm mb-4">
            <h1 class="text-primary">
                {{ $count['total_users'] }}
            </h1>
            <h6 class="mb-0">Total Users</h6>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-body  bg-success bg-opacity-10 shadow-sm mb-4">
            <h1 class="text-success">
                {{ $count['total_staff'] }}
            </h1>
            <h6 class="mb-0">Total Staff</h6>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-body  bg-warning bg-opacity-10 shadow-sm mb-4">
            <h1 class="text-warning">
                {{ $count['total_managers'] }}
            </h1>
            <h6 class="mb-0">Total Managers</h6>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-body  bg-danger bg-opacity-10 shadow-sm mb-4">
            <h1 class="text-danger">
                {{ $count['total_hod'] }}
            </h1>
            <h6 class="mb-0">Total Head of Departments</h6>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-body  bg-primary bg-opacity-10 shadow-sm mb-4">
            <h1 class="text-primary">
                {{ $count['expenses']['total'] }}
            </h1>
            <h6 class="mb-0">Total Expenses</h6>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-body  bg-warning bg-opacity-10 shadow-sm mb-4">
            <h1 class="text-warning">
                {{ $count['expenses']['pending'] }}
            </h1>
            <h6 class="mb-0">Total Pending Expenses</h6>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-body  bg-success bg-opacity-10 shadow-sm mb-4">
            <h1 class="text-success">
                {{ $count['expenses']['approved'] }}
            </h1>
            <h6 class="mb-0">Total Approved Expenses</h6>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-body  bg-danger bg-opacity-10 shadow-sm mb-4">
            <h1 class="text-danger">
                {{ $count['expenses']['rejected'] }}
            </h1>
           <h6 class="mb-0">Total Rejected Expenses</h6>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-body  bg-secondary bg-opacity-10 shadow-sm mb-4">
            <h1 class="text-secondary">
                {{ $count['expenses']['draft'] }}
            </h1>
            <h6 class="mb-0">Total Draft Expenses</h6>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-body bg-primary bg-opacity-10 shadow-sm mb-4">
            <h1 class="text-primary">
                {{ $count['total_departments'] }}
            </h1>
            <h6 class="mb-0">Total Departments</h6>
        </div>
    </div>
</div>
