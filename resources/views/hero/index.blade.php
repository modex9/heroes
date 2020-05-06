@extends('layouts.app')

@section('content')
    @foreach($heroes as $hero)
        <div style="margin-bottom: 50px;">
            <h2>{{$hero->name}} @if(isset($hero->faction))({{$hero->faction->name}})@endif</h2>
            <a href="{{route('hero.edit', $hero->id)}}" style="display: block;">Edit hero</a>

            <img src="{{$hero->picture}}" alt="{{$hero->name}}" width="200px">
            <form method="post" action="{{route('hero.destroy', $hero->id)}}" style="display: inline-block;">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit"><h1><i>x</i></h1></button>
            </form>
            <h4>{{$hero->description}}</h4>
        </div>
    @endforeach
    <a href="{{route('hero.create')}}">Create a new hero</a>
@endsection
