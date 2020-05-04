@extends('layouts.app')

@section('content')
    <form method="post" action="{{route('faction.store')}}">
        @csrf
        <div>
            <label for="name">Name</label>
            <input name="name" type="text">
        </div>
        <div>
            <label for="">Picture URL:</label>
            <input name="picture" type="text">
        </div>
        <div>
            <label for="descriptin">Description</label>
            <input name="description" type="text">
        </div>
        <button type="submit">Save</button>
    </form>
@endsection
