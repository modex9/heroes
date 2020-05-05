@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('user.store') }}" class="centered">
        @csrf
        <div style="margin: 0 auto; width: 10%; position: relative;">
            <label for="nickname">Nickame</label>
            <input type="text" name="nickname">
            <label for="email">E-mail</label>
            <input type="email" name="email">
            <label for="password">Password</label>
            <input type="password" name="password">

            <select name="role" id="role">
                @foreach($roles as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                @endforeach
            </select>
            <button type="submit">Išsaugoti</button>
        </div>
    </form>
@endsection
