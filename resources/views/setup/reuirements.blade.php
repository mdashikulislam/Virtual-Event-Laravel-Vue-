@extends('layouts.setup')
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">

            <div class="card">
                <div class="card-header">
                    Check Requirements
                </div>
                <div class="card-body">

                    <ul>
                        @foreach($results as $key => $successful)
                            <li>
                                {{$key}}
                                @if($successful)
                                    <i class="fa fa-check text-success"></i>
                                @else
                                    <i class="fa fa-times text-danger"></i>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('setup.database') }}" class="btn {{ $success ? 'btn-primary' : ' btn-danger disabled' }}">
                        Continue
                    </a>

                </div>
            </div>

        </div>
    </div>
@endsection
