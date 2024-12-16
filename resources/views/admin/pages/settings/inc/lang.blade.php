<div class="row">
    @php
        $activeTabIndex = 0;
    @endphp
    <div class="col-md-3">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            @foreach (config('laravellocalization.supportedLocales') as $key=>$value)
                <a class="nav-link mb-2 @if($loop->index == $activeTabIndex) active @endif"
                    id="v-pills-{{$key.'-'.$group_by}}-tab"
                    data-bs-toggle="pill"
                    href="#v-pills-{{$key.'-'.$group_by}}"
                    role="tab"
                    aria-controls="v-pills-{{$key.'-'.$group_by}}"
                    aria-selected="true">
                    {{ $value['native'] }}
                </a>
            @endforeach
        </div>
    </div>
    <div class="col-md-9">
        <div class="tab-content mt-4 mt-md-0" id="v-pills-tabContent">
            @foreach (config('laravellocalization.supportedLocales') as $key => $value)
                <div class="tab-pane fade @if($loop->index == $activeTabIndex) show active @endif" id="v-pills-{{$key.'-'.$group_by}}" role="tabpanel" aria-labelledby="v-pills-{{$key.'-'.$group_by}}-tab">
                    @foreach($data as $item)
                        @php
                            $field_name = $item['name'];
                            $field_val = \App\Models\Setting::where([
                                    'key'      => $field_name,
                                    'group_by' => $group_by
                                ])->first();
                            if( $field_val ) {
                                $field_val =  $field_val->translate($key)->value ?? '';
                            }
                        @endphp
                        @include('admin.component.localization_fields.'.$item['type'] ,[
                            'lang_key' => $key,
                            'label' => __($item['label']),
                            'name' => $field_name,
                            'required' => isset($item['required']) ? true : false,
                            'value' => $field_val ?? old($key.'.value'),
                            'data' => $item['type'] == 'setting_pages' ? null : null 
                        ])
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>