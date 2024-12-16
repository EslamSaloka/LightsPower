<!-- Jquery js-->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap js-->
<script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- Perfect-scrollbar js -->
<script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

<!-- Sidemenu js -->
<script src="{{ asset('assets/plugins/sidemenu/sidemenu.js') }}" id="leftmenu"></script>

<!-- Sidebar js -->
<script src="{{ asset('assets/plugins/sidebar/sidebar.js') }}"></script>

<!-- Select2 js-->
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
@include('admin.layouts.scripts.select2')

<!-- Color Theme js -->
<script src="{{ asset('assets/js/themeColors.js') }}"></script>

<!-- Sticky js -->
<script src="{{ asset('assets/js/sticky.js') }}"></script>

<!-- Custom js -->
<script src="{{ asset('assets/js/custom.js') }}"></script>

<!--- Internal Notify js -->
<script src="{{ asset('assets/plugins/notify/js/notifIt.js') }}"></script>

@if (Session::get('success'))
    <script>
        notif({
    		type: "success",
            msg: "{{ Session::get('success') }}",
            position: "center",
        })
    </script>
@endif
@if (Session::get('danger'))
    <script>
        notif({
    		type: "error",
            msg: "{{ Session::get('danger') }}",
            position: "center",
        })
    </script>
@endif
@stack('scripts')
<script>
    function showMenu() {
        if(window.localStorage.getItem("menu") == 1) {
            $('.main-body').removeClass("main-sidebar-hide");
        } else {
            $('.main-body').addClass("main-sidebar-hide");
        }
    }
    $(".mmenu").click(function(){
        if(window.localStorage.getItem("menu") == 1) {
            window.localStorage.setItem("menu",0);
            $('.main-body').removeClass("main-sidebar-hide");
        } else {
            window.localStorage.setItem("menu",1);
            $('.main-body').addClass("main-sidebar-hide");
        }
    });
    $(document).ready(function() {
        showMenu();
    });
</script>