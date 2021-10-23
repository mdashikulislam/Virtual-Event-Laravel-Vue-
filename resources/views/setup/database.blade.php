@extends('layouts.setup')
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">

            <div class="card">
                <div class="card-header">
                    Database Configuration
                </div>
                <div class="card-body">

                    <p>If you already filled the database details in your .env file the input fields should be pre-filled. Otherwise, fill the fields with the corresponding information for your database.</p>

                    @include('layouts.alerts')

                    <form action="{{ route('setup.save-database') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="db_host">
                                Database Host
                            </label>
                            <input type="text" name="db_host" id="db_host" required
                                   class="form-control{{ $errors->has('db_host') ? ' is-invalid' : '' }}"
                                   placeholder="localhost" value="{{ old('db_host') ?: env('DB_HOST', 'localhost') }}">
                            @if ($errors->has('db_host'))
                                <p class="invalid-feedback" role="alert">
                                    {{ $errors->first('db_host') }}
                                </p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="db_port">
                                Database Port
                            </label>
                            <input  type="number" name="db_port" id="db_port" required
                                   class="form-control{{ $errors->has('db_port') ? ' is-invalid' : '' }}"
                                   placeholder="3306" value="{{ old('db_port') ?: env('DB_PORT', 3306) }}">
                            @if ($errors->has('db_port'))
                                <p class="invalid-feedback" role="alert">
                                    {{ $errors->first('db_port') }}
                                </p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="db_name">
                                Database Name
                            </label>
                            <input type="text" name="db_name" id="db_name" required
                                   class="form-control{{ $errors->has('db_name') ? ' is-invalid' : '' }}"
                                   value="{{ old('db_name') ?: env('DB_DATABASE') }}">
                            @if ($errors->has('db_name'))
                                <p class="invalid-feedback" role="alert">
                                    {{ $errors->first('db_name') }}
                                </p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="db_user">
                                Database User
                            </label>
                            <input type="text" name="db_user" id="db_user" required
                                   class="form-control{{ $errors->has('db_user') ? ' is-invalid' : '' }}"
                                   value="{{ old('db_user') ?: env('DB_USERNAME') }}">
                            @if ($errors->has('db_user'))
                                <p class="invalid-feedback" role="alert">
                                    {{ $errors->first('db_user') }}
                                </p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="db_password">
                                Database Password
                            </label>
                            <input type="password" name="db_password" id="db_password"
                                   class="form-control{{ $errors->has('db_password') ? ' is-invalid' : '' }}"
                                   value="{{ old('db_password') ?: env('DB_PASSWORD') }}">
                            @if ($errors->has('db_password'))
                                <p class="invalid-feedback" role="alert">
                                    {{ $errors->first('db_password') }}
                                </p>
                            @endif
                        </div>

                        @if(session('data_present', false))
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="hidden" name="overwrite_data" value="0">
                                    <input type="checkbox" class="custom-control-input" id="overwrite_data"
                                           @if(old('overwrite_data')) checked @endif>

                                    <label class="custom-control-label text-danger" for="overwrite_data">
                                        I confirm that all data should be deleted and overwritten with a new LinkAce database
                                    </label>
                                </div>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary">
                            @if($errors->any())
                                Try again
                            @else
                                Configure Database
                            @endif
                        </button>

                        <p class="small text-muted mt-3 mb-0">Saving the database configuration and preparing it for using the app may take a few seconds, please be patient.</p>

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
