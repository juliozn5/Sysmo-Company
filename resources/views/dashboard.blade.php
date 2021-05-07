@if (Auth::user()->role == 0)
@include('content.dashboard.user.dashboard-analytics')
@else
@include('content.dashboard.admin.dashboard-analytics')
@endif