<form method="{{$method}}" id="{{$id}}" action="{{$action}}">
        @csrf
    {{$slot}}
</form>
