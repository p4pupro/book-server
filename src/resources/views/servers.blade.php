@extends('layouts.app')

@section('content')
    
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h1>Server Status</h1>
                        <a class="btn btn-primary float-right" href="{{route('book-server')}}">Book/UnBook Server</a>
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('errors'))
                            <div class="alert alert-danger">
                                {{ session('errors')->first('errorNoOwner') }}
                            </div>
                        @endif
                        <table class="table">
                            <thead class="thead-dark">
                                <tr> 
                                    <th>Server</th>
                                    <th>Status</th> 
                                    <th>Dev</th>
                                    <th>Email</th>        
                                </tr>
                            </thead>
                        @foreach($servers as $row => $data)
                           @foreach($data as $innerRow => $value)
                           <tbody>
                                <tr> 
                                  <td>{{$value->servName}}</td>
                             @if ( $value->servStatus === 'busy')
                                    <td><i class="fas fa-lock red"></i></td>
                             @else
                                    <td><a ><i class="fas fa-unlock green"></i></a></td>
                             @endif 
                                  <td>{{optional($value)->devName}}</td>
                                  <td>{{optional($value)->devEmail}}</td>    
                                </tr>
                            </tbody>
                           @endforeach
                        @endforeach
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