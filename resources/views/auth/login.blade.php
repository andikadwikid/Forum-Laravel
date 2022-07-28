@extends('layouts.app')

@section('css')

@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 fw-bold fs-5">Sign In</h5>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="username">username</label>
                                <input id="username" type="text"
                                    class="form-control @error('username') is-invalid @enderror" name="username"
                                    value="{{ old('username') }}" required autocomplete="username" autofocus>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="password">password</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Submit button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-block mb-4">Sign
                                    in</button>
                            </div>
                            </ <hr>

                            <!-- Login buttons -->
                            <div class="d-grid gap-2">
                                <div class="text-center text-muted">
                                    <p>or sign in with</p>
                                </div>

                                @component('auth.partials.button')
                                    @slot('class')
                                        bg-danger text-white
                                    @endslot
                                    @slot('route')
                                        {{ route('sign-in-socialite', 'google') }}
                                    @endslot
                                    @slot('icon')
                                        fab fa-google
                                    @endslot
                                    Sign up with Google
                                @endcomponent

                                @component('auth.partials.button')
                                    @slot('class')
                                        btn-dark
                                    @endslot
                                    @slot('route')
                                        {{ route('sign-in-socialite', 'github') }}
                                    @endslot
                                    @slot('icon')
                                        fab fa-github
                                    @endslot
                                    Sign up with Github
                                @endcomponent
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/fontawesome.js') }}"></script>
    @endpush
@endsection
