<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
<!-- Title -->
<title>@yield('title')</title>

<!-- Base  -->
<base href="{{ url('/') }}">

<!-- Favicon -->
<link rel="icon" href="{{ asset('icon.png') }}" type="image/x-icon"/>

<!-- Bootstrap css-->
<link  id="style" href="{{ url('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"/>

<!-- Icons css-->
<link href="{{ asset('assets/plugins/web-fonts/icons.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/plugins/web-fonts/font-awesome/font-awesome.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/web-fonts/plugin.css') }}" rel="stylesheet"/>

<!-- Style css-->
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />

<!-- Select2 css -->
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />

<!--- Internal  Notify -->
<link href="{{ asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet"/>

@if(App::isLocale('ar'))
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@500&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Tajawal', sans-serif;
        }
        
        *::-webkit-scrollbar {
            height: 10px !important;
        }
    </style>
@endif
<style>
    *::-webkit-scrollbar {
        height: 13px !important;
    }
</style>
<style>
    .help-block {
        color: red;
    }
    @media only screen and (max-width: 800px) {
        .main-header {
            background: #0e0e23 !important;
            color: white !important;
        }
        .mmenu a {
            color: white !important;
        }
    }
</style>



@stack('css')
<script>
    var _URL = "{{ url('/') }}";
</script>
