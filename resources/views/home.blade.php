@extends('layouts.app')

@section('content')
    @include('sweetalert::alert')
    <div class="container-fluid">
        <div class="row justify-content-center">

            <aside class="col-md-auto border-end">
                <ul class="nav flex-column">
                    <li class="nav-item border-bottom">
                        <a class="nav-link active" aria-current="page" href="#">Active</a>
                    </li>
                    <li class="nav-item border-bottom">
                        <a class="nav-link" aria-current="page" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled">Disabled</a>
                    </li>
                </ul>
            </aside>

            <main class="col-md-6">
                <div class="d-flex">
                    <div class="flex-grow-1 me-1">
                        <form action="{{ route('home.index') }}" name="searchform" method="GET">
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                                placeholder="Type to search..." />
                            <button type="submit" class='btn btn-primary visually-hidden'>Search</button>
                        </form>
                    </div>

                    <div class="text-end">
                        <a href="" class="btn btn-primary rounded-1">Ask Question</a>
                    </div>
                </div>

                @forelse ($forums as $forum)
                    <div class="container">
                        <div class="row my-2">
                            <div class="col-md-auto border-bottom text-end">
                                @include('partials.badgeAnswerForum')
                            </div>

                            <section class="col-md-9 border-bottom">
                                <a href="" class="text-decoration-none">{{ $forum->forum_title }}</a>
                                <br>
                                {{ Str::limit($forum->forum_text, 100) }}

                                <div class="d-flex flex-wrap">
                                    @foreach ($forum->tags as $tag)
                                        <div class="me-1 my-1">
                                            <small class="bg-primary opacity-50 text-white rounded-1 p-1 col">
                                                {{ '#' . $tag->name }}
                                            </small>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- <div class="col">
                                    <div class="row row-cols-auto">
                                        @foreach ($forum->tags as $tag)
                                            <div class="me-1 my-1">
                                                <small class="bg-primary opacity-50 text-white rounded-1 p-1 col">
                                                    {{ '#' . $tag->name }}
                                                </small>
                                            </div>
                                        @endforeach
                                    </div>
                                </div> --}}

                                <div class="d-flex">
                                    <div class="ms-auto my-2">
                                        <a href="" class="text-decoration-none mx-2">
                                            {{ $forum->users->username }}
                                        </a>
                                        asked {{ $forum->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                @empty
                    <div>
                        <div class="position-relative" style="min-height: 100px">
                            <div class="position-absolute top-50 start-50 translate-middle">
                                We couldn't find anything for {{ request()->title }}
                            </div>
                        </div>
                    </div>
                @endforelse
                <div class="d-flex justify-content-center">
                    <i class="bi bi-search"></i>
                    {{ $forums->withQueryString()->links() }}
                </div>

            </main>

            <aside class="col-md-2">
                <div class="card mb-3">
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="180"
                        xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder"
                        preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#20c997"></rect>
                    </svg>
                    <div class="card-body">
                        <h5 class="card-title">Example test</h5>
                        <p class="card-text">

                        </p>
                        <div class="text-center">
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">Popular</div>
                    <div class="card-body">

                    </div>

                </div>

                <div class="card mb-3">
                    <div class="card-header">Recent</div>
                    <div class="card-body">

                    </div>

                </div>
            </aside>

        </div>
    </div>
@endsection
