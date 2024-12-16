<div class="card custom-card">
    <div class="card-header border-bottom-0 custom-card-header">
        <h6 class="main-content-label mb-0">@lang('History'):</h6>
    </div>
    <div class="card-body">
        @if($histories->count() == 0)
        <h4 class="text-center">
            @lang('No history found')
        </h4>
        @else
        <div class="vtimeline">
            @foreach ($histories as $history)
                <div class="timeline-wrapper timeline-wrapper-primary">
                    <div class="timeline-badge"></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h6 class="timeline-title">@lang($history->action)</h6>
                        </div>
                        <div class="timeline-body">
                            @if($history->message)
                            @lang('Reason'): {{ $history->message }}
                            <br>
                            @endif
                            <p>@lang('By'): {{$history->user ? $history->user->full_name : ""}}</p>
                            <div class="container">
                                <div class="row justify-content-between">
                                    <div class="col">
                                        <span class="ms-md-auto"><i class="fe fe-calendar text-muted "></i>
                                            {{\Carbon\Carbon::parse($history->created_at)->format('Y/m/d H:i:s')}}
                                        </span>
                                    </div>
                                    <div class="col"></div>
                                    <div class="col">
                                        @if($history->action == 'edit' && $history->old_data && isset($show_changes))
                                            <button onclick="{{ $show_changes }}" data-id="{{$history->id}}" class="btn btn-primary">
                                                <i class="fe fe-eye"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $histories->withQueryString()->links('admin.layouts.inc.paginator') }}
        @endif
    </div>
</div>