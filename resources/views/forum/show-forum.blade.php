@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('summernote/dist/summernote-bs5.css') }}">
@stop
@section('content')
    <div class="container">
        <div class="row">
            {{-- <div class="col">

            </div> --}}

            <div class="col-10 text-break">
                <h1>{{ $forum->forum_title }}</h1>
                <hr>
                {!! $forum->forum_content !!}

                <form method="post" action="{{ route('home.answer.store', $forum->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group my-3">
                        <label class="form-label fw-bold">Your Answers</label>
                        <textarea class="form-control" id="content" name="answer_content"></textarea>
                        <p>Align center : CTRL + Shift + E </p>
                    </div>
                    <div class="form-group my-2">
                        <button type="submit" class="btn btn-danger btn-block">Publish</button>
                    </div>
                </form>
                <div class="d-flex flex-wrap mb-3">
                    @foreach ($forum->tags as $tag)
                        <div class="me-1 my-1">
                            <small class="bg-primary opacity-50 text-white rounded-1 p-1 col">
                                {{ '#' . $tag->name }}
                            </small>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex flex-wrap mb-5">

                    @can('viewEditDelete', $forum)
                        <a href="" class="me-4 text-muted text-decoration-none">
                            Edit
                        </a>
                        <a href="" class="me-4 text-muted text-decoration-none">
                            Delete
                        </a>
                    @endcan
                </div>

                <h2 class="fs-3">Answers</h2>
                @forelse ($forum->answers as $answer)
                    <section class=" text-break">
                        <div class="card my-3">
                            <div class="card-body">
                                @can('view', $answer)
                                    <div class="d-flex flex-row-reverse">
                                        <a href="" class="me-4 text-muted text-decoration-none">
                                            Edit
                                        </a>
                                    </div>
                                @endcan
                                {!! $answer->answer_content !!}

                            </div>
                            <div class="card-footer">
                                <div class="d-flex">
                                    <div class="ms-auto">
                                        <a href="" class="me-2">
                                            {{ $answer->users->username }}
                                        </a>
                                        <small class="text-muted">
                                            answered {{ $answer->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>


                @empty
                    <p class="text-center my-5">no answer yet</p>
                @endforelse
            </div>
            {{-- <div class="col"></div> --}}

        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('summernote/dist/summernote-bs5.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#content').summernote({
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
                });
            });

            $(this).summernote({
                maximumImageFileSize: 3584000 //3,5MB
            });
        </script>
    @endpush
@endsection
