@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-5">This page may have moved or is no longer available. ( Code #500)</h1>
        <p class="mt-4">We're sorry, but we can't find the page you requested.</p>
        <p class="mb-5">Please try finding what you need from <a href="{{url('/')}}">our homepage</a>.</p>
    </div>
@endsection