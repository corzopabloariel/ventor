@php
$arr = ["1" => "Cuenta ADM","2" => "Cuenta Vendedor","11" => "Cuenta Ventor"];
@endphp
<div class="d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div>
        <h1>Bienvenido<br/>{{Auth::user()["name"]}}</h1>
        <p class="m-0">{{$arr[Auth::user()["is_admin"]]}}</p>
    </div>
</div>