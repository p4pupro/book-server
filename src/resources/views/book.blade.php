@extends('layouts.app')

@section('content')
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h1>Book/UnBook Server</h1>
                        <a class="btn btn-primary float-right" href="{{route('server-status')}}">Server Status</a>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('errors'))
                        <div class="alert alert-danger">
                            {{ session('errors')->first('errorNoOwner') }}
                            {{ session('errors')->first('errorNeedLogin') }}
                        </div>
                    @endif
                        <table class="table">
                            <thead class="thead-dark">
                                <tr> 
                                    <th>Server</th>
                                    <th>Status</th> 
                                    <th>Book/UnBook</th> 
                                </tr>           
                            </thead>
                    @foreach($servers as $key => $server)
                            <tbody>
                                <tr>  
                                <td>{{$server->servName}}</td>
                                <td>{{$server->servStatus}}</td>
                    @if ($server->servStatus == 'free')
                                <td><a href="{{route('server.update',$server->servId)}}"><i class="fas fa-unlock green"></i></a></td>
                    @else
                                <td><a href="{{route('server.update',$server->servId)}}"><i class="fas fa-lock red"></i></a></td>
                    @endif      
                                </tr>
                    @endforeach
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
            <footer class="page-footer font-small blue">
              <div class="footer-copyright text-center py-3">© 2019 make with <i class="fas fa-heart red"></i> by
                <a href="https://github.com/p4pupro">p4pupro</a>
              </div>
            </footer>
@endsection

<style>

.red {
    color: red;
}
.green {
    color: green;
}
</style>

<script> 
    setTimeout(function(){
       $("div.alert").remove();
    }, 3000 ); // 3 secs
</script>