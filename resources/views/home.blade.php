@extends('layouts.app')

@section('content')
    @include('sweetalert::alert')
    <div class="container-fluid">
        <div class="row">
            <aside class="col-md-auto col-lg-1 border-end d-flex flex-column">
                <ul class="nav flex-column">
                    <li class="nav-item border-bottom rounded-1">
                        <a class="nav-link active text-dark" aria-current="page" href="#">Active</a>
                    </li>
                    <li class="nav-item border-bottom">
                        <a class="nav-link" aria-current="page" href="#">Link</a>
                    </li>
                    <li class="nav-item border-bottom">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item border-bottom">
                        <a class="nav-link disabled">Disabled</a>
                    </li>
                </ul>
            </aside>

            <main class="col-lg-8 col-md-6">
                <div class="d-flex">
                    <div class="flex-grow-1 me-1">
                        <form action="{{ route('home.index') }}" name="searchform" method="GET">
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                                placeholder="Search ..." />
                            <button type="submit" class='btn btn-primary visually-hidden'>Search</button>
                        </form>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('home.create') }}" class="btn btn-primary rounded-1">Ask Question</a>
                    </div>
                </div>

                @isset($forum)
                    <div class="border-bottom my-4">
                        <p>
                            {{ $forum->count() }} Question
                        </p>
                    </div>
                @endisset

                @isset($tags)
                    <div class="border-bottom my-4">
                        <p>
                            {{ $forums->count() }} Question tagged [{{ $tags->name }}]
                        </p>
                    </div>
                @endisset
                @forelse ($forums as $forum)
                    <div class="container-fluid">
                        <div class="row my-2">
                            <div class="col-md-3 col-lg-auto border-bottom text-end mb-2 mb-sm-2 mb-md-0 mb-lg-0">
                                @include('partials.badgeAnswerForum')
                            </div>

                            <section class="col-md-9 border-bottom">

                                <h1 class="fs-3 text-break">
                                    <a href="{{ route('home.show', $forum->slug) }}"
                                        class="text-decoration-none">{{ Str::limit($forum->forum_title, 100, '...') }}</a>
                                </h1>


                                <p class="text-muted text-break">
                                    {{ strip_tags(Str::limit($forum->forum_content, 150, '...')) }}
                                </p>

                                <div class="d-flex flex-wrap">
                                    @foreach ($forum->tags as $tag)
                                        <div class="me-1 my-1">
                                            <a href="{{ route('tags.show', $tag->slug) }}">
                                                <small class="bg-primary opacity-50 text-white rounded-1 p-1 col">
                                                    {{ '#' . $tag->name }}
                                                </small>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="d-flex">
                                    <div class="ms-auto my-2">
                                        <a href="" class="text-decoration-none mx-2">
                                            {{ $forum->users->fullname }}
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
                                <i class="bi bi-search"></i>
                                We couldn't find anything for {{ request()->title }}
                            </div>
                        </div>
                    </div>
                @endforelse
                <div class="d-flex justify-content-center">
                    {{ $forums->withQueryString()->links() }}
                </div>

            </main>

            <aside class="col-lg-3 col-md-4">
                <div class="card mb-3">
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="180"
                        xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder"
                        preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#20c997"></rect>
                    </svg>
                    <div class="card-body">
                        <h5 class="card-title">Premium</h5>
                        <p class="card-text">

                        </p>
                        <div class="text-center">
                            <a href="{{ route('payment.index') }}" class="btn btn-primary">Subscribe</a>
                        </div>
                    </div>
                </div>

                <div class="card mb-3 position-relative">
                    <i class="bi bi-pin-angle position-absolute top-0 start-100 translate-middle"></i>
                    <div class="card-header">Popular Today Question</div>
                    <div class="card-body">
                        @forelse ($popular_today_forum as $popularToday)
                            <p>
                                <a href="" class="text-decoration-none">
                                    {{ $popularToday->forum_title }}
                                </a>
                            </p>
                        @empty
                        @endforelse
                    </div>
                </div>


                <div class="card mb-3 position-relative">
                    <i class="bi bi-pin-angle position-absolute top-0 start-100 translate-middle"></i>
                    <div class="card-header">Popular Question</div>
                    <div class="card-body">
                        @forelse ($popular_forum as $popular)
                            <p>
                                <a href="" class="text-decoration-none">
                                    {{ $popular->forum_title }}
                                </a>
                            </p>
                        @empty
                        @endforelse
                    </div>
                </div>

                <div class="card mb-3 position-relative">
                    <i class="bi bi-pin-angle position-absolute top-0 start-100 translate-middle"></i>
                    <div class="card-header">Recent Question</div>
                    <div class="card-body">
                        @forelse ($recent_forum as $recent)
                            <p>
                                <a href="" class="text-decoration-none">{{ $recent->forum_title }}</a>
                            </p>
                        @empty
                        @endforelse
                    </div>

                </div>
            </aside>

        </div>
    </div>
@endsection
