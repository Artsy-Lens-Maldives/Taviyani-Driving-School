<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- Branding Image -->
    <a class="navbar-brand" href="{{ url('/home') }}">
        <img src="{{asset('Taviyani_Logo.png')}}" width="100" height="60">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarText">
        @if (Auth::guest())
            <li class="disabled"><a href="#">Not Logged In</a></li>
        @else
            <ul class="navbar-nav mr-auto">
                @role('student')
                    <li class="disabled"><a href="#">Student Login</a></li>
                @endrole
                @role('admin|instructor|office')
                <li class="nav-item">
                    <a class="nav-link" href="/home">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Students
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('/student/create') }}">Add new</a>
                        <hr>
                        @foreach ($locations as $location)
                            <a class="dropdown-item" href="{{ url('/student/ongoing/'. $location->id) }}">View all ({{ $location->name }} | Ongoing)</a>
                        @endforeach
                        <hr>
                        <a class="dropdown-item" href="{{ url('/student/all') }}">View all</a>
                        <a class="dropdown-item" href="{{ url('/student/from-site/new') }}">Registered from site</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Instructors
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('/instructor') }}">View all</a>
                        <a class="dropdown-item" href="{{ url('/instructor/create') }}">Add new</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Vehicles
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('/vehicle') }}">View all</a>
                        <a class="dropdown-item" href="{{ url('/vehicle/create') }}">Add new</a>
                    </div>
                </li>
                @endrole
                @role('admin')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Categories
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('/category') }}">View all</a>
                        <a class="dropdown-item" href="{{ url('/category/create') }}">Add new</a>
                    </div>
                </li>
                @endrole
                @role('admin|instructor|office')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Transport Fees
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('/transport-fee/theory') }}">Theory Test</a>
                        <a class="dropdown-item" href="{{ url('/transport-fee/driving') }}">Driving Test</a>
                        <a class="dropdown-item" href="{{ url('/transport-fee/license') }}">License Fee</a>
                    </div>
                </li>
                @endrole
                @role('admin')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Users
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('/users') }}">View all</a>
                        <a class="dropdown-item" href="{{ url('/users/create') }}">Add new</a>
                    </div>
                </li>
                @endrole
                @role('admin')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Theory
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('/theory/waiting') }}">Theory Waiting Page</a>
                        <hr>
                        <a class="dropdown-item" href="{{ url('/theory/manage') }}">Manage Theory Questions</a>
                    </div>
                </li>
                @endrole
                @role('admin')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Reports
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('/reports/all') }}">Reports</a>
                    </div>
                </li>
                @endrole
                <li class="nav-item">
                    <a class="nav-link" href="/table" target="_blank">View Table</a>
                </li>
            </ul>
        @endif
    </div>
</nav>