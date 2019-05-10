@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                <div class="d-flex justify-content-between">
                    <a class="btn btn-primary left" href="{{route('book-server')}}">Book Server</a>
                    <a class="btn btn-primary right" href="{{route('server-status')}}">Server Status</a>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
