@extends('layouts.setup')
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">

            <div class="card">
                <div class="card-header">
                    Account Setup
                </div>
                <div class="card-body">

                    <p>Before you can start you have to create your user account.</p>

                    @include('layouts.alerts')

                    <form action="{{ route('setup.save-account') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="name">
                                Enter your name
                            </label>
                            <input type="text" name="name" id="name"
                                   class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                   placeholder="Enter your name" aria-label="@lang('linkace.username')"
                                   value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <p class="invalid-feedback" role="alert">
                                    {{ $errors->first('name') }}
                                </p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email">
                                Enter your email address
                            </label>
                            <input type="email" name="email" id="email"
                                   class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                   placeholder="Enter your email address" aria-label="@lang('linkace.email')"
                                   value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <p class="invalid-feedback" role="alert">
                                    {{ $errors->first('email') }}
                                </p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password">
                                Enter a strong password
                            </label>
                            <input type="password" name="password" id="password"
                                   class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                   value="{{ old('password') }}" aria-label="Enter a strong password">
                            @if ($errors->has('password'))
                                <p class="invalid-feedback" role="alert">
                                    {{ $errors->first('password') }}
                                </p>
                            @else
                                <p class="form-text text-muted small">
                                    Minimum length: 8 characters
                                </p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">
                                Confirm your password
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                   value="{{ old('password_confirmation') }}" aria-label="@lang('linkace.password_confirmed')">
                            @if ($errors->has('password_confirmation'))
                                <p class="invalid-feedback" role="alert">
                                    {{ $errors->first('password_confirmation') }}
                                </p>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Create account</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
