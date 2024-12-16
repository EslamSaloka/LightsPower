<div class="dropdown main-header-notification">
    <a class="nav-link icon" href="">
        <i class="fe fe-bell header-icons"></i>
        <span class="badge bg-danger nav-link-badge">{{Auth::user()->unreadNotifications->count()}}</span>
    </a>
    <div class="dropdown-menu scrollable" id="notifications-div">
        @if (Auth::user()->notifications->count() == 0)
        <div class="header-navheading">
            <p class="main-notification-text">
                @lang('No Notifications found')    
            </p>
        </div>
        @else
        <div class="main-notification-list">
            @include('admin.layouts.inc.notifications_data', [
                'notifications' => Auth::user()->notifications()->paginate()
            ])
        </div>
        <div class="dropdown-footer">
            <a href="{{route('admin.notifications.index')}}">@lang('View All Notifications')</a>
        </div>
        @endif
    </div>
</div>