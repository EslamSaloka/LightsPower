<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
		<!-- Favicon -->
		<link rel="icon" href="{{ asset('assets/img/brand/favicon.ico') }}" type="image/x-icon"/>

		<!-- Title -->
	<title>@lang('حدث خطأ ما ...')</title>

		<!-- Bootstrap css-->
		<link  id="style" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"/>

		<!-- Icons css-->
		<link href="{{ asset('assets/plugins/web-fonts/icons.css') }}" rel="stylesheet"/>
		<link href="{{ asset('assets/plugins/web-fonts/font-awesome/font-awesome.min.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/plugins/web-fonts/plugin.css') }}" rel="stylesheet"/>

		<!-- Style css-->
		<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

	</head>

	<body class="ltr main-body leftmenu error-1">

		<!-- Loader -->
		<div id="global-loader">
			<img src="{{ asset('assets/img/loader.svg') }}" class="loader-img" alt="Loader">
		</div>
		<!-- End Loader -->

		<!-- Page -->
		<div class="page main-signin-wrapper bg-primary construction">

			<div class="container ">
				<div class="construction1 text-center details text-white">
					<div class="">
						<div class="col-lg-12">
							<h1 class="tx-140 mb-0">500</h1>
						</div>
						<div class="col-lg-12 ">
						<h1>@lang('Internal Server Error')</h1>
							<h6 class="tx-15 mt-3 mb-4 text-white-50">حدث خطأ ما ...</h6>
							<a class="btn ripple btn-success text-center mb-2" href="{{ url('/dashboard/home') }}">@lang('الرجوع للرئيسية')</a>
						</div>
					</div>
				</div>
			</div>

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

	</body>
</html>