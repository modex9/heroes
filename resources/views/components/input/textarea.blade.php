<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <textarea class="form-control" name="{{$name}}" id="{{$name}}" @if($required) {!! " required" !!}@endif>{{$value}}</textarea>
</div>
