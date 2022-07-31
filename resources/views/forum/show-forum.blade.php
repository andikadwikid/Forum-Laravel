@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-2">

            </div>
            <div class="col-9 text-break">
                <h1>{{ $forum->forum_title }}</h1>

                <div class="d-flex flex-wrap">
                    @foreach ($forum->tags as $tag)
                        <div class="me-1 my-1">
                            <small class="bg-primary opacity-50 text-white rounded-1 p-1 col">
                                {{ '#' . $tag->name }}
                            </small>
                        </div>
                    @endforeach
                </div>

                <hr>
                {!! $forum->forum_content !!}

            </div>

        </div>
    </div>
@endsection
