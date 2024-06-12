@extends('layouts.app')

@section('content')
    <div class="container mt-5">

        <div class="d-flex align-items-center justify-content-between">
            <h2>Update Expense Information</h2>

            <a href="{{ route('expenses.index') }}" class="btn btn-primary">
                Back to expenses
            </a>
        </div>


        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('expenses.update', $expense) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="amount" class="form-label">Expense Amount</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">A$</span>
                            <input
                                type="number"
                                name="amount"
                                id="amount"
                                step=".01"
                                class="form-control @error('amount') is-invalid @enderror"
                                placeholder="Enter expense amount"
                                min="0"
                                value="{{ old('amount', $expense->amount) }}"
                                required
                                title="Please enter the amount"
                            />
                        </div>

                        @error('amount')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Expense Description</label>
                        <textarea
                            name="description"
                            id="description"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Write a short description"
                            required
                            title="Please write any description"
                        >{{ old('description', $expense->description) }}</textarea>

                        @error('amount')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select
                            type="category"
                            name="category"
                            id="category"
                            class="form-select @error('category') is-invalid @enderror"
                            required
                            title="Please select one category"
                        >
                            <option value="">Choose one...</option>
                            @foreach($categories as $category)
                                <option
                                    value="{{ $category }}"
                                    @selected(old('category', $expense->category) == $category)
                                >
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>

                        @error('category')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="document" class="form-label">Expense document</label>
                        <input
                            type="file"
                            accept="application/pdf,image/*"
                            name="document"
                            id="document"
                            class="form-control @error('document') is-invalid @enderror"
                            placeholder="Upload a document"
                            aria-describedby="documentHelp"
                            title="Upload a document"
                        />

                        <p class="help-text">
                            <small>You do not need to re-upload if the file has not been changed.</small>
                        </p>

                        @error('document')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="my-3 d-flex align-items-center justify-content-between">
                        <button type="submit" class="btn btn-success">
                           @if($expense->is_active)
                                Re-submit Expense
                           @else
                                Submit Expense
                            @endif
                        </button>

                        @if(!$expense->is_active)
                            <button type="submit" name="draft" value="1" class="btn btn-secondary">
                                Save as Draft
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
