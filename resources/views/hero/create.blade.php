@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('hero.store') }}">
        @csrf
        <div style="margin: 0 auto; width: 10%; position: relative;">
            <label for="hero">Herojus</label>
            <input type="text" name="hero">
            <label for="hero">Aprašmas</label>
            <input type="text" name="description">
            <button type="submit">Išsaugoti</button>
        </div>
    </form>
@endsection