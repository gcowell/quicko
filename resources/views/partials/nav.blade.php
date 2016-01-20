<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Laravel</a>
        </div>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/') }}">Welcome</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if(auth()->guest())

                @if(!Request::is('auth/login'))
                <li><a href="{{ url('/auth/login') }}">Login</a></li>
                @endif

                @if(!Request::is('auth/register'))
                <li><a href="{{ url('/auth/register') }}">Register</a></li>
                @endif

                @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ auth()->user()->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('/users/dashboard') }}">My Dashboard</a></li>
                        <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Journeys<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('/journeys/create') }}">Create a Journey</a></li>
                        <li><a href="{{ url('/journeys') }}">View my Journeys</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Parcels<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('/parcels/create') }}">Create a Parcel</a></li>
                        <li><a href="{{ url('/parcels') }}">View my Parcels</a></li>
                    </ul>
                </li>

                @endif

            </ul>
        </div>
    </div>
</nav>