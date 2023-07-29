<nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top" data-aos="fade-down">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">
            <img src="/images/logo.svg" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item @yield('home')">
                    <a href="{{ route('home') }}" class="nav-link">Beranda</a>
                </li>
                <li class="nav-item @yield('kategori')">
                    <a href="{{ route('categories') }}" class="nav-link">Kategori</a>
                </li>
                <li class="nav-item @yield('petunjuk')">
                    <a href="{{ route('guides') }}" class="nav-link">Petunjuk</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-store nav-link px-4 text-white">Sign In</a>
                    </li>
                @endguest
            </ul>

            @auth
                <!-- Desktop Menu -->
                <ul class="navbar-nav d-none d-lg-flex">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" id="navbarDropdown" role="button" data-toggle="dropdown">
                            @if (Auth::user()->photo)
                                <img src="{{ Storage::url(Auth::user()->photo) }}" alt="Icon User"
                                    class="rounded-circle mr-2 profile-picture">
                            @else
                                <img alt="Icon User"
                                    src="https://ui-avatars.com/api/?name={{ Auth::user()->roles == 'ADMIN' ? 'Admin' : 'User' }}"
                                    class="rounded-circle mr-2 profile-picture">
                            @endif
                            {{-- <img src="/images/icon-user.png" alt="Icon User" class="rounded-circle mr-2 profile-picture"> --}}
                            Hi, {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu">
                            @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'OWNER')
                                <a href="{{ route('admin-dashboard') }}" class="dropdown-item">Dashboard</a>
                            @else
                                <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
                                <a href="{{ route('dashboard-account') }}" class="dropdown-item">Settings</a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"
                                class="dropdown-item">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    <li class="nav-item">
                        @if (Auth::user()->roles == 'USER')
                            <a href="{{ route('cart') }}" class="nav-link d-inline-block mt-2">
                                @php
                                    $carts = \App\Models\Cart::where('users_id', Auth::user()->id)->count();
                                @endphp
                                @if ($carts > 0)
                                    <img src="/images/icon-cart-filled.svg" alt="Icon Cart Not NUll/ Tidak Kosong">
                                    <div class="card-badge">{{ $carts }}</div>
                                @else
                                    <img src="/images/icon-cart-null.svg" alt="Icon Cart Null/Kosong">
                                @endif
                            </a>
                        @endif
                    </li>
                </ul>

                <!-- Mobile Menu -->
                <ul class="navbar-nav d-block d-lg-none">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            Hi, {{ Auth::user()->name }}
                        </a>
                    </li>
                    <li class="nav-item">
                        @if (Auth::user()->roles == 'USER')
                            <a href="{{ route('cart') }}" class="nav-link d-inline-block">
                                Cart
                            </a>
                        @endif
                    </li>
                </ul>
            @endauth
        </div>
    </div>
</nav>
