@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <register-component :route="'{{getenv('APP_URL')}}'"></register-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
