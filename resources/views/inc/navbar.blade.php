<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="{{config('app.url', '')}}/">{{config('app.name', 'KebapGuide')}}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{config('app.url', '')}}/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{config('app.url', '')}}/kiosks">Kiosks</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{config('app.url', '')}}/about">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{config('app.url', '')}}/services">Services</a>
            </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{config('app.url', '')}}/register">Sign Up</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{config('app.url', '')}}/login">Login</a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{config('app.url', '')}}/kiosks/create">Create Kiosk</a>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{config('app.url')}}/dashboard">Dashboard</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>