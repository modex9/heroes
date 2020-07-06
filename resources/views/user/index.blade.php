@extends('layouts.app')
@section('content')
    <div id="app">
        <table-component  ref="foo" users-route="{{route('fetchUsers')}}" roles-route="{{route('fetchRoles')}}" ban-types-route="{{route('fetchBantypes')}}"></table-component>
    </div>
    <script type="application/javascript" src="{{asset('js/app.js')}}"></script>
@endsection

