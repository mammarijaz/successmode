@extends('adminlte::page')


@section('content')
    <div class="container">
        <div class="">
            <h2 class="">User#{{$user->id}}</h2>
        </div>
        @include('errors.list')
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">Name</label><br>
                <input name="name" type="text" class="form-control" id="name" style="display:inline-block;width: 50%;"  placeholder="Full Name" value="{{$user->name}}">
            </div>
            <div class="form-group">
                <label for="email">Email address</label><br>
                <input name="email" type="email" style="display:inline-block;width: 50%;"  class="form-control disabled" disabled id="email" placeholder="name@example.com" value="{{$user->email}}">
            </div> 
            <div class="form-group">
                <label for="password">Password</label><br>
                <input name="password" type="password" style="display:inline-block;width: 50%;"  class="form-control" id="password" placeholder="Password">
            </div>

            <a class="btn btn-danger" href="{{url()->previous() == url()->current() ? '/admin/users/'.$user->id :url()->previous()}}">Cancel</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
