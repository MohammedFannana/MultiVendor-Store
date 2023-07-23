<!-- newCount is passing from NotificationMenu component class -->
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        @if($newCount)
        <span class="badge badge-warning navbar-badge">{{$newCount}}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">{{$newCount}} Notifications</span>
        <div class="dropdown-divider"></div>

        <!-- $notifications passing from NotificationMenu component class -->
        @foreach($notifications as $notification)
        <!-- use text-bold to unread motification -->
        <!-- Check the notification_id in middleware MarkNotifiactionAsRead -->
        <a href="{{$notification->data['url']}}?notification_id={{$notification->id}}" class="dropdown-item @if ($notification->unread())  text-bold @endif">
            <!-- data column in database store array inside return is inside the toDatabase function in OrderCreatedNotifiaction.php inside return -->
            <i class="{{$notification->data['icon']}} mr-2"></i> {{$notification->data['body']}}
            <span class="float-right text-muted text-sm">{{$notification->created_at->longAbsoluteDiffForHumans()}}</span>
        </a>
        <div class="dropdown-divider"></div>
        @endforeach
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
</li>