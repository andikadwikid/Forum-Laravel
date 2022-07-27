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
        {{ $forum->answers->count() }} answers
    </span>
</div>
@else
<div class="text-end">
    {{ $forum->answers->count() }} answers
</div>
@endif
