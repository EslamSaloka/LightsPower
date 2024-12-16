@if(isset($data['lang']))
    @include('admin.component.inc.tabs_lang',['data'=>$data['lang'],
    'group_key' => 'base'])
@endif
@if(isset($data['inputs']))
    @include('admin.component.inc.inputs',['data'=>$data['inputs']])
@endif
@if(isset($data['images']))
    @include('admin.component.inc.image',['data'=>$data['images']])
@endif
@if(isset($moreData))
    @include($moreData)
@endif