@extends('layouts.app')

@section('content')
    <form method="post" action="{{route('faction.update', $faction->id)}}">
        @csrf
        <div>
            <label for="name">Name</label>
            <input name="name" type="text" value="{{$faction->name}}">
        </div>
        <div>
            <label for="">Picture URL:</label>
            <input name="picture" type="text" value="{{$faction->picture}}">
        </div>
        <div>
            <label for="descriptin">Description</label>
            <input name="description" type="text" value="{{$faction->description}}">
        </div>
        <input type="hidden" name="_method" value="PUT">
        <button type="submit">Save</button>
    </form>
@endsection
