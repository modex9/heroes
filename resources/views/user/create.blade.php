@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <form method="POST" action="{{ route('user.store') }}">
                    @csrf
                    <x-input.input name="nickname" label="Nickame" type="text"/>
                    <x-input.input name="email" label="E-mail" type="email"/>
                    <x-input.input name="password" label="Password" type="password"/>
                    <x-input.select name="role" label="Klasė" :options="$roles" option-value="name"/>
                    <x-input.button text="Išsaugoti"/>
                </form>
            </div>
        </div>
    </div>
@endsection
