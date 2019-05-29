<div class="wrapper-descargas wrapper-presupuesto py-5">
    <div class="container">
        <h2 class="title text-uppercase">atención al cliente</h2>
        <h4>Análisis de transmisión</h4>

        <div class="row justify-content-md-center mb-4 iconos">
            <div class="col-md-7 col-12 d-flex justify-content-center align-items-center">
                <div>
                    <span class="img-1"></span>
                    <p class="text-uppercase">datos</p>
                </div>
                <span class="linea w-50 mx-4"></span>
                <div>
                    <span class="img-2 inactivo"></span>
                    <p class="text-uppercase">consulta</p>
                </div>
            </div>
        </div>
        <form action="{{ url('/form/transmision') }}" novalidate method="post" id="form" onsubmit="event.preventDefault(); enviar(this)" class="formulario wrapper-formulario border-top-0 bg-white" enctype="multipart/form-data">
            @method("post")
            {{ csrf_field() }}
            <div class="row justify-content-center">
                <div class="col-12 col-md-7">
                    <div id="primero">
                        <div class="form-primero"></div>
                        
                        <div class="row mt-5">
                            <div class="col-12 d-flex justify-content-end">
                                <button onclick="siguiente(this,1)" type="button" class="btn px-5 text-white text-uppercase">siguiente</button>
                            </div>
                        </div>
                    </div>
                    <div id="segundo" style="display:none">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <p class="title">Tipo de transmisión</p>
                                <div class="form-check">
                                    <input checked class="form-check-input" type="radio" value="nueva" name="transmision" id="transmisionNueva">
                                    <label class="form-check-label" for="transmisionNueva">
                                        Transmmisión Nueva
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="existente" name="transmision" id="transmisionExistente">
                                    <label class="form-check-label" for="transmisionExistente">
                                        Transmmisión Existente
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <p class="title">Tipo de correas</p>
                                <div class="form-check">
                                    <input checked class="form-check-input" type="radio" value="v" name="correa" id="correaV">
                                    <label class="form-check-label" for="correaV">
                                        Correas en V
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="sincrónica" name="correa" id="correaSincronica">
                                    <label class="form-check-label" for="correaSincronica">
                                        Correas Sincrónicas
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <fieldset>
                                    <legend class="title">Complete los valores</legend>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <input required type="text" name="potencia" placeholder="Potencia HP" class="form-control"/>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <input required type="text" name="factor" placeholder="Factor de servicio" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <input required type="text" name="poleaMotor" placeholder="RPM polea motor" class="form-control"/>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <input required type="text" name="poleaConducida" placeholder="RPM polea conducida" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <input required type="text" name="centroMin" placeholder="Entre centro Min. (mm)" class="form-control"/>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <input required type="text" name="centroMax" placeholder="Entre centro Max. (mm)" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <textarea required name="mensaje" placeholder="Mensaje" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="mt-4 perfiles">
                                    <legend>Indicar si tiene preferencia por algún perfil</legend>
                                    <div class="" style="column-count: 3">
                                        <div class="form-check">
                                            <input checked class="form-check-input" type="radio" value="AX" name="perfil" id="perfilAX">
                                            <label class="form-check-label" for="perfilAX">
                                                AX
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="5VX" name="perfil" id="perfil5VX">
                                            <label class="form-check-label" for="perfil5VX">
                                                5VX
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="DP" name="perfil" id="perfilDP">
                                            <label class="form-check-label" for="perfilDP">
                                                DP
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="B" name="perfil" id="perfilB">
                                            <label class="form-check-label" for="perfilB">
                                                B
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="BX" name="perfil" id="perfilBX">
                                            <label class="form-check-label" for="perfilBX">
                                                BX
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="8VX" name="perfil" id="perfil8VX">
                                            <label class="form-check-label" for="perfil8VX">
                                                8VX
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="3V" name="perfil" id="perfil3V">
                                            <label class="form-check-label" for="perfil3V">
                                                3V
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="C" name="perfil" id="perfilC">
                                            <label class="form-check-label" for="perfilC">
                                                C
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="CX" name="perfil" id="perfilCX">
                                            <label class="form-check-label" for="perfilCX">
                                                CX
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="AP" name="perfil" id="perfilAP">
                                            <label class="form-check-label" for="perfilAP">
                                                AP
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="5V" name="perfil" id="perfil5V">
                                            <label class="form-check-label" for="perfil5V">
                                                5V
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="3VX" name="perfil" id="perfil3VX">
                                            <label class="form-check-label" for="perfil3VX">
                                                3VX
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="CP" name="perfil" id="perfilCP">
                                            <label class="form-check-label" for="perfilCP">
                                                CP
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="A" name="perfil" id="perfilA">
                                            <label class="form-check-label" for="perfilA">
                                                A
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-12 d-flex justify-content-end">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <button onclick="siguiente(this,0)" type="button" class="btn btn-block btn-outline-secondary px-5 text-uppercase">anterior</button>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <button type="submit" class="btn text-white px-5 text-uppercase btn-block">enviar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    window.pyrus = new Pyrus("formulario_cliente");
    $("#primero > .form-primero").html(window.pyrus.formulario());
enviar = function(t) {
    if(!validar($("#segundo"))) {
        str = validarSTRING($("#segundo"));
        alertify.notify(`Complete ${str} para enviar`, 'warning');
        return false;
    }
    document.getElementById("form").submit();
}
siguiente = function(t,tt) {
    if(tt) {
        if(!validar($("#primero"))) {
            str = validarSTRING($("#primero"));
            alertify.notify(`Complete ${str} para continuar`, 'warning');
            return false;
        }
        
        $("#primero").hide();
        $("#segundo").show();
        $('.img-1').addClass("inactivo");
        $('.img-2').removeClass("inactivo");
    } else {
        $("#primero").show();
        $("#segundo").hide();
        $('.img-1').removeClass("inactivo");
        $('.img-2').addClass("inactivo");
    }
}

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
        if(string != "") string += ", ";
        string += $(this).attr("placeholder");
    });
    return string;
}
</script>
@endpush