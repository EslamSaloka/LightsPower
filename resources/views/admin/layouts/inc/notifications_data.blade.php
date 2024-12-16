@foreach ($notifications as $notification)
@if(class_exists($notification->type))
<div class="media">
    @if($notification->read_at)
        <i class="fa fa-bell"></i>
    @else
        <i class="far fa-bell"></i>
    @endif
    <div class="media-body">
        <a href="{{ route('admin.notifications.show', $notification) }}">
            <p>{{ $notification->type::generetd_msg($notification->data) }}</p>
            <span>{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
        </a>
    </div>
</div>
@endif
@endforeach