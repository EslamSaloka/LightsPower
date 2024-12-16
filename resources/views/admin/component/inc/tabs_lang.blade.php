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
<div class="panel panel-primary tabs-style-2">
    <div class=" tab-menu-heading">
        <div class="tabs-menu1">
            <ul class="nav panel-tabs main-nav-line">
                @foreach (config('laravellocalization.supportedLocales') as $locale => $value)
                    <li>
                        <a href="#{{$locale.'-'.$group_key}}-tab" class="nav-link @if($locale == $activeLangTab) active @endif mt-1" data-bs-toggle="tab">
                            {{ $value['native'] }}
                            <img src="{{ asset('assets/img/flags/'.$locale.'.svg') }}" alt="{{$locale}}" height="20" width="20">
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            @foreach (config('laravellocalization.supportedLocales') as $locale => $value)
                <div class="tab-pane @if($locale == $activeLangTab) active @endif" id="{{$locale.'-'.$group_key}}-tab">
                    @foreach ($data as $item)
                        @php
                            $field_name = $item['name'];
                        @endphp
                        @include('admin.component.localization_fields.'.$item['type'] ,[
                            'label' => __($item['label']),
                            'input_name' => $locale.'['.$field_name.']',
                            'error_name' => $locale.'.'.$field_name,
                            'required' => isset($item['required']) && $item['required'] ? true : false,
                            'value' => old($locale.'.'.$field_name) ?? ( isset($model) && isset($model->translate($locale)->$field_name) ? $model->translate($locale)->$field_name : NULL),
                            'is_editor' => isset($is_editor) ? $is_editor : false,
                        ])
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>