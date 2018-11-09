@extends('adminlte::page')


@section('content')
    <div class="container">
        <div class="">
            <h2 class="">Song</h2>
        </div>
        <table class="table">
            <tbody>
            <tr>
                <th scope="row">{{ __('Title') }}</th>
                <td>{{$song['title']}}</td>
            </tr>
            <tr>
                <th scope="row">{{ __('Original File Name') }}</th>
                <td>{{$song['originalFileName']}}</td>
            </tr>
            <tr>
                <th scope="row">{{ __('URL') }}</th>
                <td>{{$song['url']}}</td>
            </tr>
            <tr>
                <th scope="row">{{ __('Actions') }}</th>
                <td>
                    <a class="btn btn-info" href="{{route('songs.edit', $song['fileName'])}}">Edit</a>
                
                        @include('songs.deleteform', ['action' => route('songs.destroy', $song['fileName']), 'id' => $song['fileName']])
                </td>
            </tr>
            </tbody>
        </table>
        <div class="clearfix"></div>
        <hr>
        <a class="btn btn-primary" href="{{url()->previous() == url()->current() ? '/admin/songs' :url()->previous()}}">Back</a>
    </div>
@endsection
