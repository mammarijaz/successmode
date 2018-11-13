@extends('adminlte::page')


@section('content')
    <div class="container" style="width:80%">
        <div>
            <h2>Users</h2>
            <a class="btn btn-success" href="{{route('users.create')}}">Create</a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <table id="userTable" class="table table-striped table-bordered" style="width:100%">
            <thead class="thead-dark">
            <tr>
                <th >#</th>
                <th >Name</th>
                <th >Email</th>
                <th >Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    <a class="btn btn-link" href="{{route('users.show', $user->id)}}"><span class="glyphicon glyphicon-eye-open"></a>
                    <a class="btn btn-link" href="{{route('users.edit', $user->id)}}"><span class="glyphicon glyphicon-pencil"></span></a>
                    @include('users.deleteform', ['action' => route('users.destroy', $user->id), 'id' => $user->id])
                  
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>

        
    </div>
@endsection




@section('js')
    <script> 
          var table=$("#userTable").DataTable({
                              responsive: true,
                              "scrollX": true,
                              columnDefs: [
                                { "width": "80px", "targets": [0] },
                                { "width": "200px", "targets": [2] },       
                                { "width": "150px", "targets": [1,3] }
                            ] 

                          });
          $('#container').css( 'display', 'block' );
          table.columns.adjust().draw();


    </script>
@stop
