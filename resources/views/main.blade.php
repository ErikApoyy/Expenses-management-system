@extends('layouts.app')
@section('content')

<section class="py-5 border-top border-bottom afternav">
  <div class="container mt-5" id="bottomnavbar">
    <h1 class="text-center mb-4">Welcome to Utas SmartSpend.</h1>
    <p class="text-center">
      Seamless and efficient expense management system for University of
      Tasmania.
    </p>

    <div class="d-flex align-items-center justify-content-center mt-5 gap-4">
      @auth
      <a href="{{ route('expenses.index') }}" class="btn btn-secondary btn-lg">
        Master Expenses
      </a>
      @else
      <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">
        Register
      </a>
      <a href="{{ route('login') }}" class="btn btn-primary btn-lg"> Log In </a>
      @endauth
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-4 p-2">
        <div class="card">
          <div class="card-body">
            <h2 class="card-title text-center py-3">
              Streamlined Expense Reporting
            </h2>
            <p class="card-text text-center">
              Utas SmartSpend provides a user-friendly interface that
              simplifies the process of submitting and managing expense
              reports for University of Tasmania employees. With just a few
              clicks, you can submit your expenses and track their status in
              real-time.
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-4 p-2">
        <div class="card">
          <div class="card-body">
            <h2 class="card-title text-center py-3">
              Efficient Approval Workflow
            </h2>
            <p class="card-text text-center">
              Utas SmartSpend empowers HoDs and managers to efficiently
              review and approve expense reports. The intuitive interface
              enables easy access and assessment of expenses, streamlining
              the approval workflow and saving time.
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-4 p-2">
        <div class="card">
          <div class="card-body">
            <h2 class="card-title text-center py-3">
              Intuitive & Easy to Use User Interface
            </h2>
            <p class="card-text text-center">
              Utas SmartSpend has a simple to use user interface that
              requires minimal training for employees to start managing
              their expenses efficiently. Everything you need for expense
              management is available at your fingertips.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection