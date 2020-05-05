@extends('layouts.app')

@section('content')
    <form method="post" action="{{route('user.update', $user->id)}}" class="centered">
        @csrf
        <div>
            <label for="nickname">Nickname</label>
            <input name="nickname" type="text" value="{{$user->nickname}}">
        </div>
        <div>
            <label for="email">E-mail</label>
            <input name="email" type="text" value="{{$user->email}}">
        </div>
        <select name="role" id="role">
            @foreach($roles as $role)
                <option value="{{$role->id}}">{{$role->name}}</option>
            @endforeach
        </select>
        <input type="hidden" name="_method" value="PUT">
        <button type="submit">Save</button>
    </form>
@endsection
