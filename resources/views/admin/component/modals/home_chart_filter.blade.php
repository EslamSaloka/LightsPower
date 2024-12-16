<div class="modal" id="filterModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Filter')</h6>
                <button aria-label="Close" class="btn btn-sm" data-bs-dismiss="modal" type="button">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="NationalityId">@lang('Nationality')</label>
                            <select width="100%" class="form-control select2" id="NationalityId">
                                <option value="0" selected>@lang('All Countries')</option>
                                @foreach ($countries as $country)
                                    <option value="{{$country->id}}">{{ $country->nationality }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fromDate">@lang('From Date')</label>
                            <input type="date" id="fromDate" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="toDate">@lang('To Date')</label>
                            <input type="date" id="toDate" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="button-group">
                    <button class="btn ripple btn-primary" onclick="getUsersBarChar()" data-bs-dismiss="modal" type="button">@lang('Filter')</button>
                    <button class="btn ripple btn-secondary" id="modal_btn_reset" type="reset">@lang('Reset')</button>
                    <a href="#" data-bs-dismiss="modal" class="btn ripple btn-light">
                        @lang('Cancel')
                    </a>
                </div>           
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $('#modal_btn_reset').click(function(){
        $('#filterModal').children('.select2').val(-1).change();
    });
</script>
@endpush