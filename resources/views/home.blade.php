@extends('layouts.app')

@section('content')
<div class="container">
    @auth
        @if(Auth::user()->isAdmin())
            <div style="width: 50%; margin: auto; text-align: center;">
                <h2><a href="{{route('admin')}}">Admin Panel</a></h2>
            </div>
        @endif
    @endauth
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
                    @auth
                        You are logged in!
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
