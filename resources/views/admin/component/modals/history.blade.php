<div class="modal" id="HistoryModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Changes')</h6>
                <button aria-label="Close" class="btn btn-sm" data-bs-dismiss="modal" type="button">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row row-sm">
                    <div class="col-xl-12">
                        <div class="tabs-style-3">
                            <div class="tab-menu-heading">
                                <div class="tabs-menu ">
                                    <ul class="nav panel-tabs">
                                        <li class=""><a href="#old-data" class="active" data-bs-toggle="tab">@lang('Before update')</a></li>
                                        <li><a href="#new-data" data-bs-toggle="tab">@lang('After update')</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="old-data">
                                        {!! $old_data !!}
                                    </div>
                                    <div class="tab-pane" id="new-data">
                                        {!! $new_data !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>