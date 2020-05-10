<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <textarea class="form-control" name="{{$name}}" id="{{$name}}" @if(isset($required) && $required){!! "required" !!}@endif></textarea>
    <span class="invalid-feedback" role="alert" style="display: none;">
        <strong></strong>
    </span>
</div>
