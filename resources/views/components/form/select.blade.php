<div class="form-group">
    <select name="{{$name}}" id="{{$name}}" class="form-control">
        @foreach($options as $option)
            <option value="{{ $option->{$key} }}">{{$option->{$value} }}</option>
        @endforeach
    </select>
</div>
