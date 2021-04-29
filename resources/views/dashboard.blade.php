@if (Auth::user()->role == 0)
@include('content.dashboard.dashboard-analytics-user')
@else
@include('content.dashboard.dashboard-analytics')
@endif