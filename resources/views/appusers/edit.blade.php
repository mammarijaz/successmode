@extends('adminlte::page')


@section('content')
    <div class="container">
        <div class="">
            <h2 class="">Edit Song</h2>
        </div>
        @include('errors.list')
        <form action="{{ route('songs.update', $song['fileName']) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">Title</label>
                <input name="title" type="text" class="form-control" id="title" placeholder="Song Title" value="{{$song['title']}}">
            </div>
            <div class="form-group">
                <label for="email">Original File Name</label>
                <input name="originalFileName" type="text" class="form-control disabled" disabled id="originalFileName" value="{{$song['originalFileName']}}">
            </div> 
            <div class="form-group">
                <label for="email">Original File Name</label>
                <input name="originalFileName" type="text" class="form-control disabled" disabled id="originalFileName" value="{{$song['url']}}">
            </div>

            <a class="btn btn-danger" href="{{url()->previous() == url()->current() ? '/admin/songs/'.$song['fileName'] :url()->previous()}}">Cancel</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
