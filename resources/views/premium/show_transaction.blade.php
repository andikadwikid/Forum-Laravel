@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="d-flex my-3 me-3">
                    <p class="me-auto text-muted">Transaction Detail</p>
                    <p class="fw-bold">#{{ $detail->reference }}</p>
                </div>
                <div class="mt-3">
                    <h3 class="font-medium">Rp. {{ number_format($detail->amount) }}</h3>
                    <span class="badge rounded-pill text-bg-warning">
                        {{ $detail->status }}
                    </span>
                </div>
            </div>
            <div class="col">
                <p class="my-3">INSTRUCTION</p>
                <div class="accordion" id="accordionExample">
                    @foreach ($detail->instructions as $instruction)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#{{ str_replace(' ', '', $instruction->title) }}" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    {{ $instruction->title }}
                                </button>
                            </h2>
                            <div id="{{ str_replace(' ', '', $instruction->title) }}" class="accordion-collapse collapse"
                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul class="list-unstyled">
                                        @foreach ($instruction->steps as $step)
                                            <li>{{ $loop->iteration }}. {!! $step !!}
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
