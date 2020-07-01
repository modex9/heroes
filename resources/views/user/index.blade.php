@extends('layouts.app')
<script type="text/javascript">
    const banUrl = "{{route('ban.execute')}}";
    const unbanUrl = "{{route('ban.amend')}}";
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
                            <option id="ban-{{$user->id}}" value="ban-{{$user->id}}" data-target="#banModal" @if($user->isBanned()) {!! "disabled" !!}@endif>Ban</option>
                            <option id="unban-{{$user->id}}" value="unban-{{$user->id}}" data-target="#unbanModal" @if(!$user->isBanned()) {!! "disabled" !!}@endif>Unban</option>
                        </select>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="app">
        <table-component users-route="{{route('fetchUsers')}}" roles-route="{{route('fetchRoles')}}" ban-types-route="{{route('fetchBantypes')}}"></table-component>
    </div>
    <script type="application/javascript" src="{{asset('js/app.js')}}"></script>

{{--    <x-modal.modal id="banModal">--}}
{{--        <x-modal.header id="banModal"/>--}}
{{--        <x-input.form id="banForm">--}}
{{--            <x-modal.body>--}}
{{--                <x-input.textarea name="reason" label="Priežastis"/>--}}
{{--                <x-input.input name="duration" label="Trukmė (valandom)" type="number"/>--}}
{{--                <x-input.select name="type_id" label="Tipas" :options="$ban_types" option-value="name"/>--}}
{{--            </x-modal.body>--}}
{{--            <x-modal.footer>--}}
{{--                <x-modal.dismiss_btn>Close</x-modal.dismiss_btn>--}}
{{--                <x-input.button text="Save changes"/>--}}
{{--            </x-modal.footer>--}}
{{--        </x-input.form>--}}
{{--    </x-modal.modal>--}}

{{--    <x-modal.modal id="unbanModal">--}}
{{--        <x-modal.header id="unbanModal"/>--}}
{{--        <x-input.form id="unbanForm">--}}
{{--            <x-modal.body>--}}
{{--                <x-input.textarea name="reason" label="Priežastis"/>--}}
{{--            </x-modal.body>--}}
{{--            <x-modal.footer>--}}
{{--                <x-modal.dismiss_btn>Close</x-modal.dismiss_btn>--}}
{{--                <x-input.button text="Save changes"/>--}}
{{--            </x-modal.footer>--}}
{{--        </x-input.form>--}}
{{--    </x-modal.modal>--}}

@endsection
{{--<script>--}}
{{--    import Table from "../../js/components/Table";--}}
{{--    export default {--}}
{{--        components: {Table}--}}
{{--    }--}}
{{--</script>--}}
