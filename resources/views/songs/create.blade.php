@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="">
            <h2 class="">Add Song</h2>
        </div>
        @include('errors.list')
        <form action="{{ route('songs.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
                    <div class="form-group">
                        <label for="name">Name</label><br>
                        <input name="name" type="text" style="display:inline-block;width: 50%;" class="form-control" id="name" placeholder="Full Name"  value="{{old('name')}}">
                    </div>
                    <div class="form-group">
                        <label for="file">File</label>
                         <input type="file" class="form-control-file" name="songFile"  id="songFile">
                    </div>
                    <div class="form-group">
                        <a class="btn btn-danger" href="{{url()->previous() == url()->current() ? '/admin/songs/' :url()->previous()}}">Cancel</a>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>     
                
              
        </form>
    </div>
@endsection


