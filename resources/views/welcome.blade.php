@extends('layouts.app')

@section('content')
<div class="container">
    <div class="center-block text-center">
        <div>
            <h1>welcome Admin</h1>
            <h5>Please Login to continue.</h5>
            <a href="{{ route('login') }}" class="btn btn-info text-white">Login</a>
        </div>
    </div>
</div>
@endsection
