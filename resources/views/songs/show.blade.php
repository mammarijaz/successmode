@extends('adminlte::page')


@section('content')
    <div class="container">
        <div class="">
            <h2 class="">User#{{$user->id}}</h2>
        </div>
        <table class="table">
            <tbody>
            <tr>
                <th scope="row">#</th>
                <td>{{$user->id}}</td>
            </tr>
            <tr>
                <th scope="row">{{ __('Name') }}</th>
                <td>{{$user->name}}</td>
            </tr>
            <tr>
                <th scope="row">{{ __('Email') }}</th>
                <td>{{$user->email}}</td>
            </tr>
            <tr>
                <th scope="row">{{ __('Actions') }}</th>
                <td>
                    <a class="btn btn-info" href="{{route('users.edit', $user->id)}}">Edit</a>
                
                        @include('users.deleteform', ['action' => route('users.destroy', $user->id), 'id' => $user->id])
                </td>
            </tr>
            </tbody>
        </table>
        <div class="clearfix"></div>
        <hr>
        <a class="btn btn-primary" href="{{url()->previous() == url()->current() ? '/admin/users' :url()->previous()}}">Back</a>
    </div>
@endsection
