@extends('layouts.setup')
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">

            <div class="card">
                <div class="card-header">
                   Welcome
                </div>
                <div class="card-body">

                    <p>Welcome to the {{getenv('APP_NAME')}}</p>

                    <ol>
                        <li>Check if all requirements are met.</li>
                        <li>Setup up a database and check if the connection is successful.</li>
                        <li>Create your user account.</li>
                    </ol>
                    <a href="{{ route('setup.requirements') }}" class="btn btn-primary">
                        Check Requirements
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection
