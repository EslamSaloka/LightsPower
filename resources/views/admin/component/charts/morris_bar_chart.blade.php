@push('scripts')
    <!-- Internal Morrirs Chart js-->
    <script src="{{ asset('assets/plugins/morris.js/morris.min.js') }}"></script>
@endpush
@push('css')
    <!-- Internal Morrirs Chart css-->
    <link href="{{ asset('assets/plugins/morris.js/morris.css') }}" rel="stylesheet">
@endpush
<div class="card custom-card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <div class="m-0">
                        <h6 class="main-content-label mb-1">{{$title}}</h6>
                        <p class="text-muted  card-sub-title">{{$description}}</p>
                    </div>
                    <div class="m-0">
                        @include('admin.component.buttons.filter')
                    </div>
                </div>
                <div class="morris-wrapper-demo" id="{{$morisId}}"></div>
            </div>
        </div>
    </div>
</div>