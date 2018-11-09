@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="">
            <h2 class="">Create User</h2>
        </div>
        @include('errors.list')
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label><br>
                <input name="name" type="text" class="form-control" id="name" style="display:inline-block;width: 50%;" placeholder="Full Name" value="{{old('name')}}">
            </div>
            <div class="form-group">
                <label for="email">Email address</label><br>
                <input name="email" type="email" class="form-control" id="email" style="display:inline-block;width: 50%;" placeholder="name@example.com" value="{{old('email')}}">
            </div>
            <div class="form-group">
                <label for="password">Password</label><br>
                <input name="password" type="password" class="form-control" style="display:inline-block;width: 50%;" id="password" placeholder="Password">
            </div>
            <a class="btn btn-danger" href="{{url()->previous() == url()->current() ? '/admin/users/' :url()->previous()}}">Cancel</a>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
