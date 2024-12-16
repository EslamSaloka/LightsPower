<div class="form-group">
    <label for="{{$name}}">@lang($label) @if(isset($required))<span class="tx-danger">*</span>@endif</label>
    <textarea class="form-control" id="{{$name}}" name="{{$name}}" @if(isset($height)) style="height: {{$height}}px" @else style="height: 200px" @endif placeholder="@lang($label)">{{ $value }}</textarea>
    @error($name)
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>