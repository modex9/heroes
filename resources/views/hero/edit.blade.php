@extends('layouts.app')

@section('content')
    <form method="post" action="{{route('hero.update', $hero->id)}}">
        @csrf
        <div>
            <label for="name">Name</label>
            <input name="name" type="text" value="{{$hero->name}}">
        </div>
        <div>
            <label for="">Picture URL:</label>
            <input name="picture" type="text" value="{{$hero->picture}}">
        </div>
        <div>
            <label for="descriptin">Description</label>
            <input name="description" type="text" value="{{$hero->description}}">
        </div>
        <select name="faction" id="faction">
            @foreach($factions as $faction)
                <option value="{{$faction->id}}">{{$faction->name}}</option>
            @endforeach
        </select>
        <input type="hidden" name="_method" value="PUT">
        <button type="submit">Save</button>
    </form>
@endsection
