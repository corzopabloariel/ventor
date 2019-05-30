
<div class="wrapper-formulario py-5 border-top-0 bg-white">
    <div class="container">
        <h3 class="title text-center">Consulta general</h3>
        <p class="text-center">Contáctanos y te brindaremos toda la información que necesites</p>

        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-7">
                <form action="{{ url('/form/consulta') }}" novalidate id="form" onsubmit="event.preventDefault(); enviar(this);" method="post">
                @csrf
                    <div id="formulario"></div>
                    <div class="row mt-3">
                        <div class="col-12 col-md-6">
                            <div class="g-recaptcha" data-sitekey="6LeFv6IUAAAAAGE-MtiFauHZVvNN3CEjpD71ZJT1"></div>
                        </div>
                        <div class="col-12 col-md-6 d-flex align-items-center">
                            <div class="form-check">
                                <input required class="form-check-input" type="checkbox" data-placeholder="TÉRMINOS Y CONDICIONES" value="1" name="terminos" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Acepto los términos y condiciones de privacidad
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn text-uppercase d-block mx-auto text-white px-5">enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push("scripts_distribuidor")
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
window.pyrus = new Pyrus("formulario_general");
$("#formulario").html(window.pyrus.formulario());

validar = function(t, marca = true, visible = true) {
    let flag = 1;
    $(t).find('*[required]').each(function() {
        if($(this).is(":visible")) {
            if($(this).is(":invalid") || $(this).val() == "") {
                flag = 0;
                if(marca) $(this).addClass("has-error");
            }
        }
    });
    return flag;
};
validarSTRING = function(t) {
    let string = "";
    $(t).find('*[required]').each(function() {
        if($(this).is(":invalid") || $(this).val() == "") {
            if(string != "") string += ", ";
            if($(this).attr("placeholder") === undefined)
                string += $(this).data("placeholder");
            else
                string += $(this).attr("placeholder");
        }
    });
    return string;
}
enviar = function(t) {
    if(!validar($("#form"))) {
        str = validarSTRING($("#form"));
        alertify.notify(`Complete ${str} para enviar`, 'warning');
        return false;
    }
    document.getElementById("form").submit();
}
</script>
@endpush