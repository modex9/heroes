@extends('layouts.app')

@section('content')
        <ul id="admin-links" class="centered-list">
            <li><a href="{{route('hero.index')}}">Heroes</a></li>
            <li><a href="{{route('faction.index')}}">Factions</a></li>
            <li><a href="{{route('user.index')}}">Users</a></li>
        </ul>
@endsection
