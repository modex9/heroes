@extends('layouts.app')

@section('content')
    @foreach($factions as $faction)
        <div style="margin-bottom: 50px;">
            <h2>{{$faction->name}}</h2>
            <a href="{{route('faction.edit', $faction->id)}}" style="display: block;">Edit faction</a>

            <img src="{{$faction->picture}}" alt="{{$faction->name}}" width="200px">
            <form method="post" action="{{route('faction.destroy', $faction->id)}}" style="display: inline-block;">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit"><h1><i>x</i></h1></button>
            </form>
            <h4>{{$faction->description}}</h4>
        </div>
    @endforeach
    <a href="{{route('faction.create')}}">Create a new faction</a>
@endsection
