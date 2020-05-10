@extends('layouts.app')
<script type="text/javascript">
    const banUrl = "{{route('ban.execute')}}";
</script>
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
                <tr id="user-{{$user->id}}" @if($user->isBanned()) {!! "class='banned'" !!}@endif>
                    <td id="nickname-{{$user->id}}">{{$user->nickname}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->referral}}</td>
                    <td>{{$user->role->name}}</td>
                    <td>
                        <select name="user-actions" id="user-actions-{{$user->id}}">
                            <option selected disabled>Action</option>
                            <option value="{{route('user.edit', $user->id)}}">Edit</option>
                            <option value="delete-{{$user->id}}">Delete</option>
                            @if(!$user->isBanned())<option id="ban-{{$user->id}}" value="ban-{{$user->id}}" data-target="#banModal">Ban</option>@endif
                        </select>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="banModal" tabindex="-1" role="dialog" aria-labelledby="banModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="banModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="banForm">
                    <div class="modal-body">
                            @csrf
                            @include('components.form.textarea', ['label' => 'Priežastis', 'name' => 'reason', 'required' => true])
                            @include('components.form.input', ['type' => 'number', 'label' => 'Trukmė (valandom)', 'name' => 'duration', 'required' => true])
                            @include('components.form.select', ['options' => $ban_types, 'value' => 'name', 'name' => 'type_id', 'key' => 'id', 'required' => true])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
