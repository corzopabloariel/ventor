@if(auth()->guard('client')->check())
    <div id="wrapper-header"></div>
@else
    <div id="wrapper-header"></div>
@endif