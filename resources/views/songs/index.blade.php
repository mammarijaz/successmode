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
                <th scope="col">Title</th>
                <th scope="col">URL</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($songs as $song)
            <tr>
                <th scope="row">{{$song['title']}}</th>
                <td>{{$song['url']}}</td>
                <td>
                    <a class="btn btn-primary" href="{{route('songs.show', $song['fileName'])}}">Show</a>
                    <a class="btn btn-info" href="{{route('songs.edit', $song['fileName'])}}">Edit</a>
                    @include('songs.deleteform', ['action' => route('songs.destroy', $song['fileName']), 'id' => $song['fileName'] ])
                  
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        
    </div>
@endsection
