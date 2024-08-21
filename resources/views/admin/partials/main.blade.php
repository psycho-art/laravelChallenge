@extends('layouts.app')

@section('navbar')
    @include('admin.partials.navbar')
@endsection

@section('content')
    @yield('admin-content')
@endsection
