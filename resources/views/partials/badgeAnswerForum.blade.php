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
    <span class="bg-success opacity-75 text-white rounded-1 p-1">
        {{-- <i class="bi bi-check-lg"></i> --}}
        {{ $forum->answers->count() }} answers
    </span>
    <p class="mt-2">
        {{ $forum->views->count() }} views
    </p>
</div>
@else
<div class="text-end">
    <span>
        {{ $forum->answers->count() }} answers
    </span>
    <p class="mt-2">
        {{ $forum->views->count() }} views
    </p>
</div>
@endif
