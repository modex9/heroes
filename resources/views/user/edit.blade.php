@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <form method="post" action="{{route('user.update', $user->id)}}">
                    @csrf
                    {{method_field('put')}}
                    @include('components.form.input', ['type' => 'text', 'label' => 'Nickame', 'name' => 'nickname', 'value' => $user->nickname])
                    @include('components.form.input', ['type' => 'email', 'label' => 'E-mail', 'name' => 'email', 'value' => $user->email])
                    @include('components.form.select', ['options' => $roles, 'value' => 'name', 'name' => 'role', 'key' => 'id'])
                    @include('components.form.button', ['text' => 'Išsaugoti'])
                </form>
            </div>
        </div>
    </div>
@endsection
