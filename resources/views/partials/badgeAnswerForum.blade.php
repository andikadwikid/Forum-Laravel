@php
$badgeAnswer = false;
@endphp

@forelse ($forum->answers as $answer)
    @if ($answer->best_answer)
        @php
            $badgeAnswer = true;
        @endphp
    @break
@endif
@empty
@endforelse

@if ($badgeAnswer)
<div class="text-end my-2">
    <small class="bg-success opacity-75 text-white rounded-1 p-1 p-md-n1 p-lg-1">
        {{-- <i class="bi bi-check-lg"></i> --}}
        {{ $forum->answers->count() }} answers
    </small>
    <br>
    <small class="mt-2">
        {{ $forum->views->count() }} views
    </small>
</div>
@else
<div class="text-end">
    <small>
        {{ $forum->answers->count() }} answers
    </small>
    <br>
    <small class="mt-2">
        {{ $forum->views->count() }} views
    </small>
</div>
@endif
