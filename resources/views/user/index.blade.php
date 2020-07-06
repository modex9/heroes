@extends('layouts.app')
<script type="text/javascript">
    const banUrl = "{{route('ban.execute')}}";
    const unbanUrl = "{{route('ban.amend')}}";
</script>
<script src="{{ asset('js/admin/users.js') }}" defer></script>
@section('content')
    <div id="app">
        <table-component users-route="{{route('fetchUsers')}}" roles-route="{{route('fetchRoles')}}" ban-types-route="{{route('fetchBantypes')}}"></table-component>
    </div>
    <script type="application/javascript" src="{{asset('js/app.js')}}"></script>
@endsection

