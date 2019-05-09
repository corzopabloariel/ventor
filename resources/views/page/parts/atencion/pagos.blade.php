<div class="wrapper-descargas py-5">
    <div class="container">
        <h2 class="title text-uppercase">atención al cliente</h2>
        <h4>Información sobre pagos</h4>
        <div class="row mt-3 informacion">
            <div class="col-12 col-md-6 d-flex align-items-stretch">
                <div class="p-4 shadow-sm w-100 text-center">
                    {!! $datos["empresa"]["pago"] !!}
                </div>
            </div>
            <div class="col-12 col-md-6 d-flex align-items-stretch">
                <div class="p-4 shadow-sm w-100 text-center">
                    <p class="">Cuentas bancarias para efectuar el depósito</p>
                    {!! $datos["empresa"]["banco"] !!}
                </div>
            </div>
        </div>
    </div>
</div>