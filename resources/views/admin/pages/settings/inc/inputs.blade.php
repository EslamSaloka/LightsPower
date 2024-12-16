@isset($form['inputs'])
    @foreach ($form['inputs'] as $item)
        @if ($item['type'] == 'checkbox')
        @include('admin.component.form_fields.switch', [
            'label' => $item['label'],
            'name' => $item['name'],
            'value' => getSettings($item['name'])
        ])
        @elseif ($item['type'] == 'image')
        <div class="form-group ">
            <label for="user_avatar" class="col-form-label col-lg-3">@lang($item['label'])</label>
            <div class="col-lg-12">
                <input class="form-control" type="file" name="{{ $item['name'] }}" id="user_avatar">
                @error($item['name'])
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="col-lg-1">
                <img src="{{ getSettings($item['name']) }}" alt="" class="rounded-circle header-profile-user">
            </div>
        </div>
        @elseif($item['type'] == 'select')
            @include('admin.component.form_fields.select', [
                'label' => $item['label'],
                'name' => $item['name'],
                'data' => [],
                'value' => getSettings($item['name'])
            ])
        @else
            <div class="form-group">
                <label for="{{ $item['name'] }}-input" class="col-md-3 col-form-label">
                    {{ __($item['label']) }}</label>
                <div class="col-md-12">
                    <input 
                        class="form-control" 
                        type="{{ $item['type'] }}"
                        @if ($item['type'] == "number")
                            min="1"
                        @endif 
                        value="{{ getSettings($item['name']) }}" 
                        name="{{ $item['name'] }}"
                         placeholder="{{ __($item['placeholder']) }}"
                        id="{{ $item['name'] }}-input">
                    @error($item['name'])
                    <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        @endif
    @endforeach
@endisset