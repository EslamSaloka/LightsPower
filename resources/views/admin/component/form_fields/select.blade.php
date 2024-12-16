<div class="form-group">
    <label for="{{$name}}">@lang($label) @if(isset($required))<span class="tx-danger">*</span>@endif</label>
    <select 
        id="{{$name}}" 
        name="{{$name}}" 
        class="form-control 
        @if(isset($limit))
            select-limit
        @else
            select2
        @endif
        @error("$name") is-invalid @enderror"
        @isset($multiple)
            multiple
        @endisset>
        <option @isset($multiple) disabled @endif value="0">@lang('إختر') @lang($label)</option>
        @foreach ($data as $item)
            <option value="{{ $item->id }}" 
                @if(is_array($value))
                    @if(in_array($item->id,$value)) 
                        selected 
                    @endif
                @else
                    @if($item->id == $value) 
                        selected 
                    @endif
                @endif
            >
                {{ (isset($keyV)) ? $item->{$keyV} : $item->name }}
            </option>
        @endforeach
    </select>
    @if (isset($multiple))
        @php
            $nn = str_replace(['[',']'],"",$name);
        @endphp
        @error("$nn")
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    @else
        @error("$name")
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    @endif
</div>