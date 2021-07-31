<nav class="navbar navbar-expand-md shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/home') }}">
            Lucky Winners
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <i class="mdi mdi-menu mdi-36px"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @auth
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ Request::segment(1) === 'cash-cards' ? 'active' : null }}">
                    <a class="nav-link" href="{{url('/cash-cards/list')}}">Cash cards</a>
                </li>
                <li class="nav-item {{ Request::segment(1) === 'bids' ? 'active' : null }}">
                    <a class="nav-link" href="{{url('/bids/list')}}">Bids</a>
                </li>
                <li class="nav-item {{ Request::segment(1) === 'scratch-cards' ? 'active' : null }}">
                    <a class="nav-link" href="{{url('/scratch-cards/list')}}">Scratch cards</a>
                </li>
                <li class="nav-item {{ Request::segment(1) === 'paids' ? 'active' : null }}">
                    <a class="nav-link" href="{{url('/paids/list')}}">Paid</a>
                </li>
            </ul>
            @endauth

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item {{ Request::segment(1) === 'login' ? 'active' : null }}">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="{{asset('images/man.svg')}}" alt="">
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <p class="text-center">{{ Auth::user()->name }}</p>
                            <hr>
                            <a class="dropdown-item" href="{{ url('/profile') }}">
                                <i class="mdi mdi-account"></i> Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();"><i class="mdi mdi-logout-variant"></i> Logout</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>