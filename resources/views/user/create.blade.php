@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <form method="POST" action="{{ route('user.store') }}">
                    @csrf
                    @include('components.form.input', ['type' => 'text', 'label' => 'Nickame', 'name' => 'nickname'])
                    @include('components.form.input', ['type' => 'email', 'label' => 'E-mail', 'name' => 'email'])
                    @include('components.form.input', ['type' => 'password', 'label' => 'Password', 'name' => 'password'])
                    @include('components.form.select', ['options' => $roles, 'value' => 'name', 'name' => 'role', 'key' => 'id'])
                    @include('components.form.button', ['text' => 'Išsaugoti'])
                </form>
            </div>
        </div>
    </div>
@endsection
