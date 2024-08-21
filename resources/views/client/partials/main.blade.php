@extends('layouts.app')

@section('navbar')
    @include('client.partials.navbar')
@endsection

@section('content')
    @yield('client-content')
@endsection
