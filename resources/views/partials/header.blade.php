<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- Branding Image -->
    <a class="navbar-brand" href="{{ url('/home') }}">
        <img src="{{asset('Taviyani_Logo.png')}}" width="100" height="60">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/table" target="_blank">View Table</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Students
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ url('/student') }}">View all</a>
                    <a class="dropdown-item" href="{{ url('/student/create') }}">Add new</a>
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
        </ul>
    </div>
</nav>