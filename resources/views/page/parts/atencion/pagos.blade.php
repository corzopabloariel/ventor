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
<div class="wrapper-formulario py-5">
    <div class="container">
        <h3 class="title text-center">Informar pago</h3>
        <p class="text-center">Contáctanos y te brindaremos toda la información que necesites</p>
        <div class="row justify-content-center">
            <div class="col-12 col-md-8" id="formulario"></div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="g-recaptcha" data-sitekey="6LeFv6IUAAAAAGE-MtiFauHZVvNN3CEjpD71ZJT1"></div>
                    </div>
                    <div class="col-12 col-md-6 d-flex align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="terminos" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Acepto los términos y condiciones de privacidad
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push("scripts_distribuidor")
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
    window.pyrus = new Pyrus("formulario_atencion");
    $("#formulario").html(window.pyrus.formulario());
</script>
@endpush