@extends('layouts.app')

@section('content')
    <div class="container mt-5">

        <div class="d-flex align-items-center justify-content-between">
            <h2>Expense Information</h2>

            <a href="{{ route('expenses.index') }}" class="btn btn-primary">
                Back to expenses
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                Expense Details
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered m-0">
                    <tr>
                        <th style="width: 200px">Submitted by:</th>
                        <td>{{ $expense->user?->name }}</td>
                    </tr>
                    <tr>
                        <th>Amount:</th>
                        <td>A${{ $expense->amount }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $expense->description }}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{ $expense->category }}</td>
                    </tr>
                    <tr>
                        <th>Supporting Document</th>
                        <td>
                            @if($expense->document)
                                <a href="{{ asset('storage/' . $expense->document) }}" target="_blank">
                                    View Document
                                </a>
                            @else
                                None.
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            {{ $expense->global_status }}

                            @if($expense->canBeEdited())
                                <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-secondary btn-sm ms-4">
                                    Edit and Re-submit
                                </a>
                            @endif
                        </td>
                    </tr>
                    @if(auth()->id() === $expense->user_id || $expense->isManager(auth()->user()))
                        <tr>
                            <th>Feedback (Manager)</th>
                            <td>{{ $expense->remarks_manager ?? 'N/A' }}</td>
                        </tr>
                    @endif
                    @if(auth()->id() === $expense->user_id || $expense->isHod(auth()->user()))
                        <tr>
                            <th>Feedback (H.O.D)</th>
                            <td>{{ $expense->remarks_hod ?? 'N/A' }}</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>

        @if($expense->user_id !== auth()->id())
            <div class="card mt-4">
                <div class="card-header">
                    Review Expense
                </div>
                <div class="card-body">
                    @if($expense->isManager(auth()->user()))

                        {{-- Check if the submission has been approved by the manager (current user). If not, show form --}}
                        @if($expense->status_manager === 'Submitted')
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="approve-tab" data-bs-toggle="tab"
                                            data-bs-target="#approve" type="button" role="tab" aria-controls="home"
                                            aria-selected="true">
                                        Approve
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="reject-tab" data-bs-toggle="tab"
                                            data-bs-target="#reject" type="button" role="tab"
                                            aria-controls="profile"
                                            aria-selected="false">
                                        Reject
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="approve" role="tabpanel"
                                     aria-labelledby="approve-tab">
                                    <form class="px-3 py-4" action="{{ route('expenses.approve-manager', $expense) }}"
                                          method="post">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="response_approve" class="form-label">Your Feedback
                                                (optional)</label>
                                            <input
                                                type="text"
                                                name="response"
                                                id="response_approve"
                                                value="{{ old('response') }}"
                                                class="form-control"
                                            >
                                        </div>

                                        <button type="submit" class="btn btn-primary">Approve Submission</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="reject" role="tabpanel"
                                     aria-labelledby="reject-tab">
                                    .
                                    <form class="px-3 py-4" action="{{ route('expenses.reject-manager', $expense) }}"
                                          method="post">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="response_reject" class="form-label">Reason for rejection
                                                (required)</label>
                                            <input
                                                type="text"
                                                name="response"
                                                id="response_reject"
                                                value="{{ old('response') }}"
                                                class="form-control"
                                                required
                                            >
                                        </div>

                                        <button type="submit" class="btn btn-danger">Reject Submission</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <p class="mb-0">You have {{ $expense->status_manager }} this expense submission.</p>
                        @endif

                    @elseif($expense->isHod(auth()->user()))
                        @if($expense->status_manager === 'Approved')
                            @if($expense->status_hod === 'Submitted')
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="approve-tab" data-bs-toggle="tab"
                                                data-bs-target="#approve" type="button" role="tab"
                                                aria-controls="approve"
                                                aria-selected="true">
                                            Approve
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="reject-tab" data-bs-toggle="tab"
                                                data-bs-target="#reject" type="button" role="tab"
                                                aria-controls="reject"
                                                aria-selected="false">
                                            Reject
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="approve" role="tabpanel"
                                         aria-labelledby="approve-tab">
                                        <form class="px-3 py-4" action="{{ route('expenses.approve-hod', $expense) }}"
                                              method="post">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="response" class="form-label">Your Feedback</label>
                                                <input
                                                    type="text"
                                                    name="response"
                                                    id="response"
                                                    value="{{ old('response') }}"
                                                    class="form-control"
                                                >
                                            </div>

                                            <button type="submit" class="btn btn-primary">Approve Submission</button>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="reject" role="tabpanel"
                                         aria-labelledby="reject-tab">
                                        <form class="px-3 py-4" action="{{ route('expenses.reject-hod', $expense) }}"
                                              method="post">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="response" class="form-label">Reason for Rejection
                                                    (Required)</label>
                                                <input
                                                    type="text"
                                                    name="response"
                                                    id="response"
                                                    value="{{ old('response') }}"
                                                    class="form-control"
                                                    required
                                                >
                                            </div>

                                            <button type="submit" class="btn btn-danger">Reject Submission</button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                You have {{ $expense->status_hod }} this expense submission.
                            @endif
                        @else
                            <p>The Manager has not yet approved this expense submission. You can review it after they
                                have
                                approved the submission.</p>
                        @endif
                    @else
                        <!-- For System Manager -->
                        <p>Manager Review:
                            <b>{{ $expense->status_manager === 'Submitted' ? 'Not Reviewed Yet' : $expense->status_manager }}</b>
                            /
                            Feedback: {{ $expense->remarks_manager ?? 'N/A' }}</p>
                        <p>H.O.D Review:
                            <b>{{ $expense->status_hod === 'Submitted' ? 'Not Reviewed Yet' : $expense->status_hod }}</b>
                            / Feedback: {{ $expense->remarks_hod ?? 'N/A' }}</p>
                    @endif
                </div>
            </div>
        @endif

        @if(auth()->user()->isSystemManager())
            <div class="card mt-3">
                <div class="card-header">System Manager Actions</div>
                <div class="card-body">
                    <button type="button" onclick="confirmDelete()" class="btn btn-danger">
                        Delete
                    </button>

                    <hr>

                    <h4>Change Status</h4>

                    <form action="{{ route('expenses.update-status', $expense) }}" method="post">
                        @csrf

                        <div class="mb-3">
                            <label for="status_hod" class="form-label">
                                Status (HOD)
                            </label>

                            <select name="status_hod" id="status_hod" class="form-select @error('status_hod') is-invalid @enderror">
                                <option value="">Select Status</option>
                                @foreach($statuses as $status)
                                    <option
                                        value="{{ $status }}"
                                        @selected($status === $expense->status_hod)
                                    >
                                        {{ Str::title($status) }}
                                    </option>
                                @endforeach
                            </select>

                            @error('status_hod')
                            <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="remarks_hod">Remarks (If any)</label>
                            <input
                                type="text"
                                name="remarks_hod"
                                id="remarks_hod"
                                value="{{ old('remarks_hod', $expense->remarks_hod) }}"
                                class="form-control @error('remarks_hod') is-invalid @enderror"
                            >

                            @error('remarks_hod')
                            <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>

            @if($expense->canBeDeleted())
                <form method="POST" action="{{ route('expenses.destroy', $expense) }}" id="delete-form">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        @endif
    </div>

    <script>
        function confirmDelete() {
            if (confirm("Are you sure you want to delete this expense submission?")) {
                document.getElementById("delete-form").submit();
            }
        }
    </script>
@endsection
