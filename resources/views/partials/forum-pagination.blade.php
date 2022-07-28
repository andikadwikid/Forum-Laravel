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
                <div class="col">
                    <div class="row row-cols-auto">
                        {{-- <div class="d-flex flex-row"> --}}
                        @foreach ($forum->tags as $tag)
                            <div class="me-1 my-1">
                                <small class="bg-primary opacity-50 text-white rounded-1 p-1 col">
                                    {{ '#' . $tag->name }}
                                </small>
                            </div>
                        @endforeach

                    </div>
                </div>
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
                Data tidak ada
            </div>
        </div>
    </div>
@endforelse

<div id="pagination">
    <div class="d-flex justify-content-center">
        {{ $forums->links() }}
    </div>
</div>
