<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(\App::getLocale() == "ar")  style="direction:rtl" @endif>
	<head>
		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
		<!-- Favicon -->
		<link rel="icon" href="{{ asset('icon.png') }}" type="image/x-icon"/>

		<!-- Title -->
		<title>
            @lang('تسجيل الدخول') | {{ env('APP_NAME') }} - @lang('Dashboard')
        </title>

		<!-- Base  -->
		<base href="{{ url('/') }}">

		@if(App::isLocale('ar'))
			<!-- Bootstrap css-->
			<link  id="style" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.rtl.min.css') }}" rel="stylesheet"/>
		@else
			<!-- Bootstrap css-->
			<link  id="style" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"/>
		@endif

		<!-- Icons css-->
		<link href="{{ asset('assets/plugins/web-fonts/icons.css') }}" rel="stylesheet"/>
		<link href="{{ asset('assets/plugins/web-fonts/font-awesome/font-awesome.min.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/plugins/web-fonts/plugin.css') }}" rel="stylesheet"/>

		<!-- Style css-->
		<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

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

	<body class="@if(App::isLocale('ar')) rtl @else ltr @endif main-body leftmenu error-1">
		<!-- Loader -->
		<div id="global-loader">
			<img src="{{ asset('assets/img/loader.svg') }}" class="loader-img" alt="Loader">
		</div>
		<!-- End Loader -->

		<!-- Page -->
		<div class="page main-signin-wrapper">

			<!-- Row -->
			<div class="row signpages">
				<div class="col-md-12">
					<div class="card">
						<div class="row row-sm">
							<div class="col-lg-6 col-xl-5 d-none d-lg-block text-center bg-primary details">
								<div class="mt-5 pt-4 p-2 pos-absolute">
									<img src="{{ getSettings("logo",asset('/dashboard.svg')) }}" style=" position: relative; left: 15px; " class="d-lg-none header-brand-img text-start float-start mb-4 error-logo-light" alt="logo">
									<img src="{{ getSettings("logo",asset('/dashboard.svg')) }}" style=" position: relative; left: 15px; " class=" d-lg-none header-brand-img text-start float-start mb-4 error-logo" alt="logo">
									<div class="clearfix"></div>
									<img src="{{ getSettings("logo",asset('/dashboard.svg')) }}" class="ht-100 mb-0" alt="user" style="margin-left: 25px;">
									<h5 class="mt-4 text-white"></h5>
									<span class="tx-white-6 tx-13 mb-5 mt-xl-0">@lang('تسجيل الدخول لإنشاء المجتمع العالمي واكتشافه والتواصل معه')</span>
								</div>
							</div>
							<div class="col-lg-6 col-xl-7 col-xs-12 col-sm-12 login_form  xxsl" style="">
								<div class="main-container container-fluid">
									<div class="row row-sm">
										<div class="card-body mt-2 mb-2">
											<img src="{{ getSettings("logo",asset('/dashboard.svg')) }}" style=" position: relative; left: 22px; " class=" d-lg-none header-brand-img text-start float-start mb-4" alt="logo">
											<div class="clearfix"></div>
                                            <form style="direction: ltr;" method="POST" action="{{ route('admin.login') }}">
												@csrf
												<h5 class="text-start mb-2">@lang('تسجيل دخول إلي لوحه التحكم')</h5>
												<p class="mb-4 text-muted tx-13 ms-0 text-start">@lang('تسجيل الدخول لإنشاء المجتمع العالمي واكتشافه والتواصل معه')</p>
												
                                                <div class="form-group ">
                                                    <label for="email">
                                                        @lang('إسم المستخدم أو الجوال أو البريد الإلكتروني')
                                                    </label>
                                                    <input type="text" class="form-control @error('object') is-invalid @enderror"
                                                        name="object"
                                                        id="email"
                                                        value="{{ old('object') }}"
                                                        placeholder="@lang('إسم المستخدم أو الجوال أو البريد الإلكتروني')">
                                                        @error('object')
                                                            <span class="text-danger">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>@lang('كلمة المرور')</label>
                                                    <div class="input-group auth-pass-inputgroup">
                                                        <input type="password" class="form-control @error('كلمة المرور') is-invalid @enderror" placeholder="@lang('Enter password')" name="password" aria-label="Password" aria-describedby="password-addon">
                                                    </div>
                                                    @error('password')
                                                        <span class="text-danger text-start">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group mg-b-25">
                                                    <label class="ckbox mg-b-5">
                                                        <input type="checkbox" name="remember_me">
                                                        <span class="tx-14"> @lang('تذكرني')</span>
                                                    </label>
                                                </div>
        
                                                <div class="mt-3 d-grid">
                                                    <button class="btn ripple btn-main-primary btn-block" type="submit">@lang('تســــجيل دخول')</button>
                                                </div>
                                            </form>

											<div class="text-start mt-5 ms-0">
												<div class="mb-1"><a href="{{ route('admin.forgetPassword.index') }}">@lang('نسيت كلمة المرور ؟')</a></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="mt-5 text-center">
						<span>@lang('حقوق النشر') © {{ date('Y') }} <a href="#">{{ getSettings("system_name",env('APP_NAME')) }}</a> @lang('جميع الحقوق محفوظة').</span>
                	</div>
				</div>
			</div>
			<!-- End Row -->

		</div>
		<!-- End Page -->

		<!-- Jquery js-->
		<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

		<!-- Bootstrap js-->
		<script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

		<!-- Select2 js-->
		<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
		@include('admin.layouts.scripts.select2')

		<!-- Perfect-scrollbar js -->
		<script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

		<!-- Color Theme js -->
		<script src="{{ asset('assets/js/themeColors.js') }}"></script>

		<!-- Custom js -->
		<script src="{{ asset('assets/js/custom.js') }}"></script>

		<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
        {{-- {!! JsValidator::formRequest('App\Http\Requests\Dashboard\Auth\AuthRequest') !!} --}}

	</body>
</html>