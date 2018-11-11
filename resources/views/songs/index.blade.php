@extends('adminlte::page')


@section('content')
    <div class="container" style="width:80%">
        <div>
            <h2>Add Song</h2>
            <a class="btn btn-success" href="{{route('songs.create')}}">Create</a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <table id="songTable" class="cell-border">
            <thead>
            <tr>
                <th >Title</th>
                <th >URL</th>
                <th >Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($songs as $song)
            <tr>
                <td >{{$song['title']}}</td>
                <td>{{$song['url']}}</td>
                <td>
                    <a class="btn btn-link" href="{{route('songs.show', $song['fileName'])}}"><span class="glyphicon glyphicon-eye-open"></span></a>
                    <a class="btn btn-link" href="{{route('songs.edit', $song['fileName'])}}"><span class="glyphicon glyphicon-pencil"></span></a>
                    @include('songs.deleteform', ['action' => route('songs.destroy', $song['fileName']), 'id' => $song['fileName'] ])
                  
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        
    </div>
@endsection

@section('js')
    <script> 
          var table=$("#songTable").DataTable({
                              responsive: true,
                              "scrollX": true,
                              columnDefs: [
                                { "width": "100px", "targets": [0] },
                                { "width": "400px", "targets": [1] },       
                                { "width": "150px", "targets": [2] }
                            ]  });
          $('#container').css( 'display', 'block' );
          table.columns.adjust().draw();  
                          </script>
@stop
