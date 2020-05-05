@extends('layouts.app')
<script src="{{ asset('js/admin/users.js') }}" defer></script>
@section('content')
    <div class="centered">
        <table id="user-table" class="centered">
            <thead>
            <th>Nickname</th>
            <th>E-mail</th>
            <th>Referral</th>
            <th>Role</th>
            <th><a href="{{route('user.create')}}">+</a></th>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr id="user-{{$user->id}}">
                    <td>{{$user->nickname}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->referral}}</td>
                    <td>{{$user->role->name}}</td>
                    <td>
                        <select name="user-actions" id="user-actions-{{$user->id}}">
                            <option selected disabled>Action</option>
                            <option value="{{route('user.edit', $user->id)}}">Edit</option>
                            <option value="delete-{{$user->id}}">Delete</option>
                        </select>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
