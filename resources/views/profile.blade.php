@extends('layouts.app')

@section('navbar')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ url('/') }}">
        {{ config('app.name', 'Laravel') }}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">Home</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item mr-3">
                <form action="{{ route('loginForm') }}" method="GET" class="d-inline">
                    <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('loginForm') }}'">
                        Login
                    </button>
                </form>
            </li>
            <li class="nav-item">
                <form action="{{ route('register') }}" method="GET" class="d-inline">
                    <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('register') }}'">
                        Register
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>

@endsection

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4 text-center">
            <div class="profile-img">
                <img src="{{ $user['picture']['large'] }}" alt="{{ $user['name']['first'] }}" class="rounded-circle img-fluid shadow-lg">
            </div>
        </div>
        <div class="col-md-8">
            <div class="profile-info">
                <h2 class="font-weight-bold">{{ $user['name']['first'] }} {{ $user['name']['last'] }}</h2>
                <hr>
                <p><strong>Email:</strong> {{ $user['email'] }}</p>
                <p><strong>Location:</strong> {{ $user['location']['city'] }}, {{ $user['location']['country'] }}</p>
                <p><strong>Gender:</strong> {{ ucfirst($user['gender']) }}</p>
                <p><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($user['dob']['date'])->format('d M Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
