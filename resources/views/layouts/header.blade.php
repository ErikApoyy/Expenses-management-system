<nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#" id="navtext" color="text-white">Utas SmartSpend</a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <!-- @class(["nav-link", 'active']) -->
                    <a class="nav-link {{request()->is('/') ? 'active' : '' }}" href="{{route('index') }}"> 
                        Home
                    </a>
                </li>

                @if(auth()->check())
                    <li class="nav-item">
                        <a class="nav-link {{request()->is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            Dashboard
                        </a>
                    </li>

                    @if(auth()->user()->canEditUsers())
                        <li class="nav-item">
                            <a class="nav-link {{request()->is('users') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                Manage Users
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->isSystemManager())
                        <li class="nav-item">
                            <a class="nav-link {{request()->is('departments') ? 'active' : '' }}" href="{{ route('departments.index') }}">
                                Manage Departments
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->canEditExpenses())
                        <li class="nav-item">
                            <a class="nav-link {{request()->is('expenses/create') ? 'active' : '' }}" href="{{ route('expenses.create') }}">
                                Submit Expenses
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link {{request()->is('expenses') ? 'active' : '' }}" href="{{ route('expenses.index') }}">
                            @if(auth()->user()->isSystemManager())
                                Master
                            @endif

                            Expenses
                        </a>
                    </li>
                @endif
            </ul>
            <ul class="navbar-nav">
                @if(!auth()->check())
                    <li class="nav-item">
                        <a class="nav-link {{request()->is('register') ? 'active' : '' }}" href="{{ route('register') }}">
                            Registration
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{request()->is('profile') ? 'active' : '' }}" href="{{ route('profile.index') }}">
                            Profile
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#"
                           onclick="document.getElementById('logout-form').submit()">Log Out</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<form method="POST" action="{{ route('logout') }}" id="logout-form">
    @csrf
</form>
