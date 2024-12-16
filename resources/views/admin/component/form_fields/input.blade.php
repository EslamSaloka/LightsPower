@if ($type == "checkbox")
    <label class="custom-switch">
        <input type="checkbox" name="{{$name}}" class="custom-switch-input" checked value="1">
        <span class="custom-switch-indicator"></span>
        @if (isset($label))
        <span class="custom-switch-description">@lang($label)</span>
        @endif
    </label>
@else
    <div class="form-group">
        <label for="{{$name}}">@lang($label) @if(isset($required) && $required)<span class="tx-danger">*</span>@endif</label>
        <input 
            type="{{$type}}" 
            @isset($min) min="{{$min}}" @endisset 
            @isset($readOnly) readonly @endisset 
            class="form-control" 
            id="{{$name}}" 
            name="{{$name}}" 
            placeholder="@lang($label)" 
            value="{{ $value }}">
        @error($name)
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
        <span class="text-danger" id="error_{{$name}}"></span>
    </div>
@endif