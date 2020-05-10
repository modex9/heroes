<div class="form-group">
    <select name="{{$name}}" id="{{$name}}" class="form-control" @if($required){!! "required" !!}@endif>
        @foreach($options as $option)
            <option value="{{ $option->{$key} }}">{{$option->{$value} }}</option>
        @endforeach
    </select>
    <span class="invalid-feedback" role="alert" style="display: none;">
        <strong></strong>
    </span>
</div>
