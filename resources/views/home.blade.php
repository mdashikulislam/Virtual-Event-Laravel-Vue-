@extends('layouts.app')
@section('content')
    <div class="">
        <events-component :route="'{{getenv('APP_URL')}}'"></events-component>
    </div>
@endsection
