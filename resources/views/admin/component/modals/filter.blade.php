<div class="modal" id="filterModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Filter')</h6>
                <button aria-label="Close" class="btn btn-sm" data-bs-dismiss="modal" type="button">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <form action="{{ $url }}" method="get" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                    @foreach ($fields as $field)
                        @if(isset($field['col']))
                        <div class="col-md-{{$field['col']}} mt-2">
                        @else
                        <div class="col-md-12 mt-2">
                        @endif
                            @include('admin.component.filter_fields.'.$field['type'], [
                                'label' => $field['label'],
                                'name' => $field['name'],
                                'data' => isset($field['data']) ? $field['data'] : [],
                                'translate' => isset($field['translate']) ? true : false 
                            ])
                        </div>
                    @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="button-group">
                        <button class="btn ripple btn-primary" type="submit">@lang('Filter')</button>
                        <button class="btn ripple btn-secondary" id="modal_btn_reset" type="reset">@lang('Reset')</button>
                        <a href="{{$url}}" class="btn ripple btn-light">
                            @lang('Cancel')
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $('#modal_btn_reset').click(function(){
            $('.select2').val([]).trigger("change");
        });
    </script>
@endpush