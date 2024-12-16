<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(\App::getLocale() == "ar")  style="direction:rtl" @endif>
    <head>
        <meta charset="utf-8" />
        <title>
            @lang('استعانه كلمة المرور') | {{ env('APP_NAME') }} - @lang('Dashboard')
        </title>

        <!-- Base  -->
		<base href="{{ url('/') }}">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="{{ url('icon.png') }}">
        @if(App::isLocale('ar'))
			<!-- Bootstrap css-->
			<link  id="style" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.rtl.min.css') }}" rel="stylesheet"/>
		@else
			<!-- Bootstrap css-->
			<link  id="style" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"/>
		@endif
        {{-- <link href="{{ url('/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" /> --}}
        <link href="{{ url('/assets/css/icon-list.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('/assets/css/style.css') }}" id="app-style" rel="stylesheet" type="text/css" />

        @if(App::isLocale('ar'))
			<link rel="preconnect" href="https://fonts.googleapis.com">
			<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
			<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@500&display=swap" rel="stylesheet">
			<style>
				* {
					font-family: 'Tajawal', sans-serif;
				}
			</style>
		@endif
		<style>
			.help-block {
				color: red;
			}
            .rtl .signpages .details:before {
				background-color: black !important;
			}
            @media only screen and (max-width: 800px) {
				.xxsl {
					background: black !important;
					color: white !important;
				}
			}
		</style>

    </head>
    <body>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="card-body pt-0">
                                <div class="p-2">
                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @else
                                        <form style="direction: ltr;" class="form-horizontal" method="POST" action="{{ route('admin.resetPassword.send') }}">
                                            @csrf
                                            <div class="mb-3" style="text-align: end;">
                                                <label for="email" class="form-label">
                                                    @lang('Email')
                                                </label>
                                                <input
                                                    type="email"
                                                    class="form-control"
                                                    name="email"
                                                    id="email"
                                                    value="{{ old('email') }}"
                                                    placeholder="@lang('Enter email')">
                                            </div>
                                            @error('email')
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    <i class="mdi mdi-alert-outline me-2"></i>
                                                        {{ $errors->first('email') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @enderror
                                            
                                            <div class="mb-3" style="text-align: end;">
                                                <label for="otp" class="form-label">
                                                    @lang('كود التحقبق')
                                                </label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="otp"
                                                    id="otp"
                                                    value="{{ old('otp') }}"
                                                    placeholder="@lang('إدخل كود التحقبق')">
                                            </div>
                                            @error('otp')
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    <i class="mdi mdi-alert-outline me-2"></i>
                                                        {{ $errors->first('otp') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @enderror

                                            <div class="mb-3" style="text-align: end;">
                                                <label for="password" class="form-label">
                                                    @lang('كلمة المرور')
                                                </label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="password"
                                                    id="password"
                                                    value="{{ old('password') }}"
                                                    placeholder="@lang('إدخل كلمة المرور')">
                                            </div>
                                            @error('password')
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    <i class="mdi mdi-alert-outline me-2"></i>
                                                        {{ $errors->first('password') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @enderror

                                            @if(Session::get('danger'))
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    <i class="mdi mdi-alert-outline me-2"></i>
                                                    {{ Session::get('danger') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @endif

                                            <div class="mt-3 d-grid">
                                                <button class="btn btn-primary waves-effect waves-light" type="submit">@lang('تعيين')</button>
                                            </div>
                                        </form>
                                    @endif
                                </div>

                            </div>
                        </div>
                        <div class="mt-5 text-center">

                            <div>
                                <span>@lang('حقوق النشر') © {{ date('Y') }} <a href="#">{{ getSettings("system_name",env('APP_NAME')) }}</a> @lang('جميع الحقوق محفوظة').</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script src="{{ url('/assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ url('/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ url('/assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ url('/assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ url('/assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ url('/assets/js/app.js') }}"></script>
    </body>
</html>
