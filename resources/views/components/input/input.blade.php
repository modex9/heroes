<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <input type="{{$type}}" class="form-control" name="{{$name}}" id="{{$name}}" value="{{ $value ?? '' }}" @if($required){!! " required" !!}@endif>
</div>
