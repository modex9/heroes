<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <input type="{{$type}}" class="form-control" name="{{$name}}" id="{{$name}}" @if(isset($value)) {!! "value=" !!}{{$value}}@endif>
</div>
