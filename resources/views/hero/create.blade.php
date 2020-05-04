@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('hero.store') }}">
        @csrf
        <div style="margin: 0 auto; width: 10%; position: relative;">
            <label for="name">Hero</label>
            <input type="text" name="name">
            <label for="picture">Picture</label>
            <input type="text" name="picture">
            <label for="hero">Description</label>
            <input type="text" name="description">
            <select name="faction" id="faction">
                @foreach($factions as $faction)
                    <option value="{{$faction->id}}">{{$faction->name}}</option>
                @endforeach
            </select>
            <button type="submit">Išsaugoti</button>
        </div>
    </form>
@endsection
