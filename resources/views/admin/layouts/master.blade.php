<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(\App::getLocale() == "ar")  style="direction:rtl" @endif>
<head>
    @include('admin.layouts.inc.head')
</head>
<?php $themeDir = App::getLocale() == 'ar' ? 'rtl' : 'ltr'; ?>
<body class="{{$themeDir}} main-body leftmenu">
    <!-- Loader -->
    <div id="global-loader">
        <img src="{{ asset('assets/img/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- End Loader -->

    <!-- Loading Modal -->
    @include('admin.component.inc.loading')
    <!-- Loading Modal End -->

    <!-- Page -->
    <div class="page">

        <!-- Main Header-->
        @include('admin.layouts.inc.header')
        <!-- End Main Header-->

        <!-- Sidemenu -->
        @include('admin.layouts.inc.menu')
        <!-- End Sidemenu -->

        <!-- Main Content-->
        <div class="main-content side-content pt-0">
            <div class="main-container container-fluid">
                <div class="inner-body">
                    <!-- Page Header -->
                    <div class="page-header">
                        @include('admin.layouts.inc.breadcrumb')
                        <div class="d-flex">
                            <div class="justify-content-center">
                                @yield('buttons')
                            </div>
                        </div>
                    </div>
                    <!-- End Page Header -->
                    <!-- Row -->
                    @yield('PageContent')
                    <!-- End Row -->
                </div>
            </div>
        </div>
        <!-- End Main Content-->

        <!-- Main Footer-->
        @include('admin.layouts.inc.footer')
        <!--End Footer-->

    </div>
    <!-- End Page -->

    <!-- Back-to-top -->
    <a href="#top" id="back-to-top"><i class="fe fe-arrow-up"></i></a>

    @include('admin.layouts.inc.scripts')
</body>
</html>
