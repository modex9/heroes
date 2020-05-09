@extends('layouts.app')

@section('content')
<h2 style="display: inline;">Esate užbanintas iki </h2><h4 style="display: inline;">{{$user->bans->last()->getBannedUntilDate()}} </h4>
<h4>Banas baigsis po {{$user->bans->last()->getBanEndsIn()}} </h4>
@endsection
