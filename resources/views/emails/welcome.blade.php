@component('mail::message')

@component('mail::panel')
    {!! $message !!}
@endcomponent

@component('mail::button', [
    'url' => $url,
])
@endcomponent

@lang('شكرا لك'),<br>
{{ getSettings("system_name",env('APP_NAME')) }}
@endcomponent
