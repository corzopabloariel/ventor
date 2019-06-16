@php
$arr = ["1" => "Cuenta ADM","2" => "Cuenta Vendedor","11" => "Cuenta Ventor"];
@endphp
<div class="d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div>
        <h1>Bienvenido<br/>{{Auth::user()["name"]}}</h1>
        @if(Auth::user()["is_admin"] == 2)
            @if(strpos(Auth::user()["username"], "EMP_") !== false)
            <p class="m-0">{{$arr[11]}}</p>
            @else
            <p class="m-0">{{$arr[Auth::user()["is_admin"]]}}</p>
            @endif
        @else
        <p class="m-0">{{$arr[Auth::user()["is_admin"]]}}</p>
        @endif
    </div>
</div>