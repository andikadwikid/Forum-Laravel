<nav class="navbar navbar-expand-lg bg-light shadow-sm sticky-top ">
    <div class="container">
        <a class="navbar-brand" href="#">Simple Forum</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('home.index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
            </ul>

            @guest
                <div class="d-flex">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <li>
                            <a href="{{ route('login') }}" class="btn btn-primary me-1 mb-1">
                                Login
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="btn btn-primary">
                                Sign up
                            </a>
                        </li>

                    </ul>
                </div>
            @else
                <div class="dflex">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="btn btn-outline-dark dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ Auth::user()->avatar }}" class="rounded-circle mx-1" height="30"
                                    alt="{{ Auth::user()->username }}" loading="lazy" />
                                {{ Auth::user()->firstname }}
                                <i class="bi bi-patch-check text-success"></i>
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
