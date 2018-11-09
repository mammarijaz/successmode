@extends('adminlte::page')


@section('content')
    <div class="container">
        <div>
            <h2>Users</h2>
            <a class="btn btn-success" href="{{route('users.create')}}">Create</a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr>
                <th scope="row">{{$user->id}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    <a class="btn btn-primary" href="{{route('users.show', $user->id)}}">Show</a>
                    <a class="btn btn-info" href="{{route('users.edit', $user->id)}}">Edit</a>
                    @include('users.deleteform', ['action' => route('users.destroy', $user->id), 'id' => $user->id])
                  
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
@endsection
