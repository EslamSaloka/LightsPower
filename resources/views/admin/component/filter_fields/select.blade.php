<label for="{{$name}}">@lang($label)</label>
<select name="{{$name}}" class="form-control select2-with-search" id="{{$name}}">
    <option value="-1">@lang('إختر')</option>
    @foreach ($data as $item)
        <option value="{{$item['id']}}">{{ $translate ? __($item['name']) : $item['name'] }}</option>
    @endforeach
</select>