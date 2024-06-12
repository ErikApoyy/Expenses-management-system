@extends('layouts.app')

@section('content')
    <div class="container mt-5">

        <div class="d-flex align-items-center justify-content-between">
            <h2>Submit New Expense</h2>

            <a href="{{ route('expenses.index') }}" class="btn btn-primary">
                Back to expenses
            </a>
        </div>


        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('expenses.store') }}" enctype="multipart/form-data">
                    @csrf

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
                        ></textarea>

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
                                <option value="{{ $category }}">{{ $category }}</option>
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
                            required
                            title="Upload a document"
                        />

                        @error('document')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="my-3 d-flex align-items-center justify-content-between">
                        <button type="submit" class="btn btn-success">
                            Submit my expense
                        </button>

                        <button name="draft" value="1" type="submit" class="btn btn-secondary">
                            Save as Draft
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
