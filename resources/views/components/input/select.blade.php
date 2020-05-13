<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <select name="{{$name}}" id="{{$name}}" class="form-control" @if($required){!! " required" !!}@endif>
        @foreach($options as $option)
            <option value="{{ $option->{$optionKey} }}">{{$option->{$optionValue} }}</option>
        @endforeach
    </select>
</div>
