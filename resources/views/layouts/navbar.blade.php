<nav class="navbar navbar-expand-lg bg-light shadow-sm sticky-top ">
    <div class="container">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
            </ul>

            @guest
                <div class="d-flex">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @if (request()->is('register'))
                            <li>
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    Login
                                </a>
                            </li>
                        @endif
                        @if (request()->is('login'))
                            <li>
                                <a href="{{ route('register') }}" class="btn btn-primary">
                                    Sign up
                                </a>
                            </li>
                        @endif

                    </ul>
                </div>
            @else
                <div class="dflex">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle nav-link" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">

                                <img src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp" class="rounded-circle"
                                    height="30" alt="Black and White Portrait of a Man" loading="lazy" />
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a
                                        class="dropdown-item disabled text-dark fw-semibold">{{ Auth::user()->firstname }}</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </ul>
                        </li>
                    </ul>
                </div>
            @endguest
        </div>
    </div>
    <div class="progress-container position-absolute top-100 start-50 translate-middle">
        <div class="progress-bar" id="myBar"></div>
    </div>
</nav>
