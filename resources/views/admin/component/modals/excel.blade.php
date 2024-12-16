<div class="modal" id="excelModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Import Excel')</h6>
                <button aria-label="Close" class="btn btn-sm" data-bs-dismiss="modal" type="button">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex">
                    <div class="justify-content-center">
                        <form action="{{ route('admin.questions.excel_template') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn ripple btn-info">
                                @lang('Excel Template')
                            </button>
                        </form>
                    </div>
                </div>
                <form id="excel_form" action="{{ $url }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            @include('admin.component.form_fields.file', [
                                'label' => 'Excel File',
                                'name'  => 'excel_file',
                                'value' => NULL,
                                'required' => true,
                            ])
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="button-group">
                            <button type="submit" class="btn btn-primary">
                            @lang('Submit')
                        </button>
                            <button type="button" data-bs-dismiss="modal" class="btn ripple btn-light">
                                @lang('Cancel')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $('#excel_form').on('submit', function(){
        $('#excelModal').modal('hide');
        $('#loadingModal').modal('show')
    });
</script>
@error('excel_file')
<script>
    $(function(){
        $('#excelModal').modal('show');
    });
</script>
@enderror
@endpush