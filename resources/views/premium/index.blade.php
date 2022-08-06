@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="d-flex">
                    @foreach ($channels as $channel)
                        @if ($channel->active == true)
                            <form action="{{ route('premium.transaction') }}" method="POST">
                                @csrf
                                <input type="hidden" name="premium_id" value="1">
                                <input type="hidden" name="method" value="{{ $channel->code }}">
                                <button type="submit" class="btn btn-outline-primary me-3">

                                    {{ $channel->name }}

                                </button>
                            </form>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

    </div>
@endsection
