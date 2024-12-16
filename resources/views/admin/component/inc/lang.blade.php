<div class="row">
    <div class="col-md-3">
        @php
            $activeLangTab = array_key_first(config('laravellocalization.supportedLocales'));
            $continue = true;
        @endphp
        @foreach (config('laravellocalization.supportedLocales') as $lang_key => $value)
            @if($continue)
                @foreach (\Arr::pluck($data, 'name') as $locale_name)
                    @error($lang_key.'.'.$locale_name)
                        @php 
                            $activeLangTab = $lang_key;
                            $continue = false;
                        @endphp
                        @break
                    @enderror
                @endforeach
            @endif
        @endforeach
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            @foreach (config('laravellocalization.supportedLocales') as $key=>$value)
                <a class="nav-link mb-2 @if($key == $activeLangTab) active @endif"
                    id="v-pills-{{$key.'-'.$group_key}}-tab"
                    data-bs-toggle="pill"
                    href="#v-pills-{{$key.'-'.$group_key}}"
                    role="tab"
                    aria-controls="v-pills-{{$key.'-'.$group_key}}"
                    aria-selected="true">
                    {{ $value['native'] }}
                </a>
            @endforeach
        </div>
    </div>
    <div class="col-md-9">
        <div class="tab-content mt-4 mt-md-0" id="v-pills-tabContent">
            @foreach (config('laravellocalization.supportedLocales') as $key => $value)
                <div class="tab-pane fade @if($key == $activeLangTab) show active @endif" id="v-pills-{{$key.'-'.$group_key}}" role="tabpanel" aria-labelledby="v-pills-{{$key.'-'.$group_key}}-tab">
                    @foreach ($data as $item)
                        @php
                            $field_name = $item['name'];
                        @endphp
                        @include('admin.component.localization_fields.'.$item['type'] ,[
                            'label' => __($item['label']),
                            'input_name' => $key.'['.$field_name.']',
                            'error_name' => $key.'.'.$field_name,
                            'required' => isset($item['required']) && $item['required'] ? true : false,
                            'value' => old($key.'.'.$field_name) ?? ( isset($model) && isset($model->translate($key)->$field_name) ? $model->translate($key)->$field_name : NULL),
                            'is_editor' => isset($is_editor) ? $is_editor : false,
                        ])
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>