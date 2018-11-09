@extends('adminlte::page')


@section('content')
    <div class="container">
        <div>
            <h2>Add Song</h2>
            <a class="btn btn-success" href="{{route('songs.create')}}">Create</a>
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
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            
            </tbody>
        </table>
        
    </div>
@endsection
