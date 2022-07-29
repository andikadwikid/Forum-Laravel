@extends('layouts.app')

@section('content')
    <div class="container-sm">

        <div class="text-break">

            {!! $forum->forum_content !!}
        </div>


    </div>
@endsection
