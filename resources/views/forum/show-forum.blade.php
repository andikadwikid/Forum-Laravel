@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('summernote/dist/summernote-bs5.css') }}">
    <style>
        .imgContainer {
            position: relative;
            overflow-x: auto;
            overflow-y: auto;
            width: 100%;
            max-width: 100%;
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 text-break">
                <h1>{{ $forum->forum_title }}</h1>
                <hr>
                {!! $forum->forum_content !!}

                <div class="d-flex flex-wrap mb-3">
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

                <form method="post" action="{{ route('home.answer.store', $forum->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group my-3">
                        <label class="form-label fw-bold mt-4">Your Answers</label>
                        <textarea class="form-control" id="content" name="answer_content"></textarea>
                        <p>Align center : CTRL + Shift + E </p>
                    </div>
                    <div class="form-group my-2">
                        <button type="submit" class="btn btn-primary btn-block">Post Your Answer</button>
                    </div>
                </form>

                <div class="d-flex flex-wrap mb-5">

                    @can('viewEditDelete', $forum)
                        <a href="{{ route('home.edit', $forum->slug) }}" class="me-4 text-muted text-decoration-none">
                            Edit
                        </a>
                        <form action="{{ route('home.destroy', $forum->slug) }}" method="POST" id="delete-forum">
                            @csrf
                            @method('delete')
                            <a href="#" class="me-4 text-muted text-decoration-none"
                                onclick="document.getElementById('delete-forum').submit()">
                                Delete
                            </a>
                        </form>
                    @endcan
                </div>

                <h2 class="fs-3">Answers</h2>
                @forelse ($forum->answers as $answer)
                    <section class="text-break">
                        <div class="border p-2 mb-4 border-opacity-10 rounded-1">

                            @can('view', $answer)
                                <div class="d-flex flex-row-reverse">
                                    <a href="" class="me-4 text-muted text-decoration-none">
                                        Edit
                                    </a>
                                </div>
                            @endcan
                            <div class="imgContainer">

                                {!! $answer->answer_content !!}
                            </div>

                            <div class="d-flex">
                                <div class="ms-auto">
                                    <a href="" class="text-decoration-none me-2">
                                        {{ $answer->users->fullname }}
                                    </a>
                                    <small class="text-muted">
                                        answered {{ $answer->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </div>

                    </section>


                @empty
                    <p class="text-center my-5">no answer yet</p>
                @endforelse
            </div>

            <div class="col-md-3 col-sm">

                <div class="card mb-3 position-relative">
                    <i class="bi bi-pin-angle position-absolute top-0 start-100 translate-middle"></i>
                    <div class="card-header">Popular Today Question</div>
                    <div class="card-body">
                        @forelse ($popular_today_forum as $popularToday)
                            <p>
                                <a href="" class="text-decoration-none">
                                    {{ Str::limit($popularToday->forum_title, 35) }}
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
                                    {{ Str::limit($popular->forum_title, 35) }}
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
                                <a href="" class="text-decoration-none">
                                    {{ Str::limit($recent->forum_title, 35) }}

                                </a>
                            </p>
                        @empty
                        @endforelse
                    </div>

                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="{{ asset('summernote/dist/summernote-bs5.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#content').summernote({
                    // width: 800,
                    height: 300,
                    popover: {
                        image: [
                            ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                            ['float', ['floatLeft', 'floatRight', 'floatNone']],
                            ['remove', ['removeMedia']]
                        ],
                    },
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['insert', ['link', 'picture', 'hr']],
                    ],
                    // callbacks: {
                    //     onImageUpload: function(files) {

                    //         if (!files.length) return;
                    //         var file = files[0];
                    //         // create FileReader
                    //         var reader = new FileReader();
                    //         reader.onloadend = function() {
                    //             // when loaded file, img's src set datauri
                    //             console.log("img", $("<img>"));
                    //             var img = $("<img>").attr({
                    //                 src: reader.result,
                    //                 width: "90%"
                    //             }); // << Add here img attributes !
                    //             console.log("var img", img);
                    //             $('#content').summernote("insertNode", img[0]);
                    //         }

                    //         if (file) {
                    //             // convert fileObject to datauri
                    //             reader.readAsDataURL(file);
                    //         }

                    //     }
                    // }
                });
            });

            $(this).summernote({
                maximumImageFileSize: 3584000 //3,5MB
            });
        </script>
    @endpush
@endsection
