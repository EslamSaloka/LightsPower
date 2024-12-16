@foreach ($inputs as $input)
    @php
        $label = ucwords(str_replace('_',' ',$input['name']));
    @endphp
    @if ($input['type'] == "header")
        <hr>
        <h5 class="font-size-14">
            <i class="mdi mdi-arrow-right text-primary"></i>
            @lang($label)
        </h5>
    @elseif ($input['type'] == "select")
        @php
            $value = old($input['name'],(isset($info)) ? $info->{$input['name']} : '');
        @endphp
        <div class="form-group">
            <select name="{{$input['name']}}" class="form-control select2" id="floating{{$input['name']}}Input">
                <option value="0">@lang('Choose '.$label)</option>
                @foreach ($items as $one)
                    <option @if($value == $one->id) @endif value="{{ $one->id }}">{{ $one->name }}</option>
                @endforeach
            </select>
            <label for="floating{{$input['name']}}Input">@lang($label)</label>
            @error($input['name'])
                <span style="color:red;">
                    {{ $errors->first($input['name']) }}
                </span>
            @enderror
        </div>

    @elseif ($input['type'] == "image")
        <div class="mb-3 row">
            <label for="user_{{ $input['name'] }}" class="col-form-label col-lg-2">@lang($label)</label>
            <div @if (isset($info)) class="col-lg-9" @else class="col-lg-11" @endif>
                <input class="form-control" type="file" name="{{$input['name']}}" id="user_{{ $input['name'] }}">
                @error($input['name'])
                    <span style="color:red;">
                        {{ $errors->first($input['name']) }}
                    </span>
                @enderror
            </div>
            @if (isset($info))
                <div class="col-lg-1">
                    <img src="{{ (new \App\Support\Image)->displayImageByModel($info,$input['name']) }}" alt="" class="rounded-circle header-profile-user">
                </div>
            @endif
        </div>

    @elseif ($input['type'] == "textarea")
        @php
            $value = old($input['name'],(isset($info)) ? $info->{$input['name']} : '');
        @endphp
        <div class="form-group">
            <textarea class="form-control"  
                id="floating{{$input['name']}}Input" 
                name="{{ $input['name'] }}" 
                placeholder="@lang('Enter '.$label)" style="height: 200px">{{ $value }}</textarea>
            <label for="floating{{$input['name']}}Input">@lang($label)</label>
            @error($input['name'])
                <span style="color:red;">
                    {{ $errors->first($input['name']) }}
                </span>
            @enderror
        </div>
    @else
        @php
            $value = old($input['name'],(isset($info)) ? $info->{$input['name']} : '');
        @endphp
        <div class="form-group">
            <input 
                type="{{ $input['type'] }}" 
                class="form-control" 
                value="{{ $value }}" 
                id="floating{{$input['name']}}Input" 
                name="{{ $input['name'] }}" 
                placeholder="@lang('Enter '.$label)" />
            <label for="floating{{$input['name']}}Input">@lang($label)</label>
            @error($input['name'])
                <span style="color:red;">
                    {{ $errors->first($input['name']) }}
                </span>
            @enderror
        </div>
    @endif
@endforeach