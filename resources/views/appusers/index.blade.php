@extends('adminlte::page')


@section('content')
    <div class="container" style="width:80%">
        <div>
            <h2>User List</h2>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <table id="usersTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th >E-mail</th>
                <th >Created At</th>
                <th >Deleted</th>
                <th >Subscribed</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr>
                <td >{{$user['email']}}</td>
                <td>{{ date('Y-m-d H:i:s', strtotime($user['createdAt'])) }}</td>
                <td>{{$user['isDeleted']?'Yes':'No'}}</td>
                <td>{{$user['isReceiveNews']?'Yes':'No'}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        
    </div>
@endsection

@section('js')
    <script> 
          var table=$("#usersTable").DataTable({
                              responsive: true,
                              "scrollX": true,
                              columnDefs: [
                                { "width": "250px", "targets": [0] },
                                { "width": "100px", "targets": [1] },       
                                { "width": "40px", "targets": [2,3] }
                            ]  });
            
                          </script>
@stop
