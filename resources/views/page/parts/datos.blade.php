<div class="modal bd-example-modal-sm" id="modalPass" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Cambio de contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formPass" onsubmit="event.preventDefault(); changePass(this);" action="{{ route('client.changepass') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input required type="password" placeholder="Contraseña actual" name="pass" id="pass" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input required onblur="verificar(this,'pass_2')" type="password" placeholder="Contraseña nueva" name="pass_1" id="pass_1" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input required onblur="verificar(this,'pass_1')" type="password" placeholder="Repita contraseña nueva" name="pass_2" id="pass_2" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div style="overflow-x: auto; overflow-y: hidden">
                                <div class="g-recaptcha" data-sitekey="6Lf8ypkUAAAAAKVtcM-8uln12mdOgGlaD16UcLXK"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" disabled id="btnConfirmar" class="btn btn-primary">Cambiar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="wrapper-contacto wrapper-datos py-5">
    <div class="container mt-2 mb-5">
        <h3 class="title text-uppercase" style="font-size: 32px; color: #595959; font-weight: 200">Mis datos</h3>
        <div id="datosNo">
            <div class="row">
                <div class="col-12 col-md-6 text-right"><strong class="text-uppercase">empresa</strong></div>
                <div class="col-12 col-md-6">{{ $datos["datos"]["name"] }}</div>
            </div>
            <div class="row">
                @if(isset($datos["cliente"]))
                <div class="col-12 col-md-6 text-right"><strong class="text-uppercase">cuit</strong></div>
                @else
                <div class="col-12 col-md-6 text-right"><strong class="text-uppercase">usuario</strong></div>
                @endif
                <div class="col-12 col-md-6">{{ $datos["datos"]["username"] }}</div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 d-flex align-items-center justify-content-end"><strong class="text-uppercase">contraseña</strong></div>
                <div class="col-12 col-md-6 d-flex align-items-center">
                    @if(isset($datos["empleado"]))
                    NO
                    @elseif(isset($datos["vendedor"]))
                    NO
                    @else
                    SI <button data-toggle="modal" data-target="#modalPass" class="btn ml-3 btn-sm btn-warning px-2" style="background: #ffc107">CAMBIAR <i class="fas fa-key"></i></button>
                    @endif
                </div>
            </div>
            @if(isset($datos["cliente"]))
                <div class="row">
                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
                        <strong class="text-uppercase">número de cuenta</strong>
                    </div>
                    <div class="col-12 col-md-6 d-flex align-items-center">{{ $datos["cliente"]["nrocta"] }}</div>
                </div>
                <fieldset class="border-top">
                    <legend class="d-inline-block pr-3" style="width: auto;">TRANSPORTE</legend>
                    <div class="row">
                        <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
                            <strong class="text-uppercase">Transportista</strong>
                        </div>
                        <div class="col-12 col-md-6 d-flex align-items-center">{{ $datos["cliente"]->transporte["descrp"]}}</div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
                            <strong class="text-uppercase">Dirección</strong>
                        </div>
                        <div class="col-12 col-md-6 d-flex align-items-center">{{ $datos["cliente"]->transporte["tradir"]}}</div>
                    </div>
                </fieldset>
            @endif
        </div>
        @if(isset($datos["empleado"]))
        <div class="row">
            <div class="col-12 col-md-6 text-right">
                <strong class="text-uppercase">email</strong>
            </div>
            <div class="col-12 col-md-6">{{ empty($datos["empleado"]["email"]) ? "-" : $datos["empleado"]["email"] }}</div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 text-right">
                <strong class="text-uppercase">CUIT</strong>
            </div>
            <div class="col-12 col-md-6">{{ str_replace("EMP_","",$datos["empleado"]["username"]) }}</div>
        </div>
        @endif
        <form id="formDatos" action="" onsubmit="event.preventDefault(); enviar(this);" method="post" class="mt-3">
        @csrf
        @if(isset($datos["cliente"]))
        <fieldset class="border-top">
            <legend class="d-inline-block pr-3" style="width: auto;">DOMICILIO</legend>
            <div class="row">
                <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
                    <strong class="text-uppercase">Dirección</strong>
                </div>
                <div class="col-12 col-md-6 d-flex align-items-center">
                    <input placeholder="Dirección" disabled type="text" name="direcc" maxlength="60" id="" class="bg-ligth px-3 py-0 form-control rounded-0 border-top-0 border-left-0 border-right-0 border-bottom" value="{{ $datos['cliente']['direcc'] }}">
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
                    <strong class="text-uppercase">Provincia</strong>
                </div>
                <div class="col-12 col-md-6 d-flex align-items-center">
                    <input placeholder="Provincia" disabled maxlength="60" type="text" name="provincia" id="" class="bg-ligth px-3 py-0 form-control rounded-0 border-top-0 border-left-0 border-right-0 border-bottom" value="{{ $datos['cliente']->localidad['descr_001'] }}">
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
                    <strong class="text-uppercase">Localidad</strong>
                </div>
                <div class="col-12 col-md-6 d-flex align-items-center">
                    <input placeholder="Localidad" disabled maxlength="60" type="text" name="localidad" id="" class="bg-ligth px-3 py-0 form-control rounded-0 border-top-0 border-left-0 border-right-0 border-bottom" value="{{ $datos['cliente']->localidad['descrp'] }}">
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
                    <strong class="text-uppercase">Código postal</strong>
                </div>
                <div class="col-12 col-md-6 d-flex align-items-center">
                    <input placeholder="Código postal" disabled type="text" name="codpos" id="" class="bg-ligth px-3 py-0 form-control rounded-0 border-top-0 border-left-0 border-right-0 border-bottom" value="{{$datos['cliente']->localidad['codpos'] }}">
                </div>
            </div>
        </fieldset>
        <fieldset class="border-top">
            <legend class="d-inline-block pr-3" style="width: auto;">CONTACTO</legend>
            <div class="row">
                <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
                    <strong class="text-uppercase">responsable</strong>
                </div>
                <div class="col-12 col-md-6 d-flex align-items-center">
                    <input placeholder="Responsable" disabled type="text" maxlength="60" name="respon" id="" class="bg-ligth px-3 py-0 form-control rounded-0 border-top-0 border-left-0 border-right-0 border-bottom" value="{{ $datos['cliente']['respon'] }}">
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
                    <strong class="text-uppercase">teléfono</strong>
                </div>
                <div class="col-12 col-md-6 d-flex align-items-center">
                    <input placeholder="Teléfono" disabled type="text" maxlength="30" name="telefn" id="" class="bg-ligth px-3 py-0 form-control rounded-0 border-top-0 border-left-0 border-right-0 border-bottom" value="{{ $datos['cliente']['telefn'] }}">
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
                    <strong class="text-uppercase">whatsapp</strong>
                </div>
                <div class="col-12 col-md-6 d-flex align-items-center">
                    <input placeholder="Whatsapp" disabled maxlength="40" type="text" name="whatsapp" id="" class="bg-ligth px-3 py-0 form-control rounded-0 border-top-0 border-left-0 border-right-0 border-bottom" value="{{ $datos['cliente']['whatsapp'] }}">
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
                    <strong class="text-uppercase">instagram</strong>
                </div>
                <div class="col-12 col-md-6 d-flex align-items-center">
                    <input placeholder="Instagram" disabled maxlength="40" type="text" name="instagram" id="" class="bg-ligth px-3 py-0 form-control rounded-0 border-top-0 border-left-0 border-right-0 border-bottom" value="{{ $datos['cliente']['instagram'] }}">
                </div>
            </div>
            {{--<div class="row">
                <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
                    <strong class="text-uppercase">fax</strong>
                </div>
                <div class="col-12 col-md-6 d-flex align-items-center">
                    {{ empty($datos["cliente"]["nrofax"]) ? "-" : $datos["cliente"]["nrofax"] }}
                </div>
            </div>--}}
            <div class="row">
                <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
                    <strong class="text-uppercase">email</strong>
                </div>
                <div class="col-12 col-md-6 d-flex align-items-center">
                    <input placeholder="Email" disabled maxlength="60" type="email" name="email" id="" class="bg-ligth px-3 py-0 form-control rounded-0 border-top-0 border-left-0 border-right-0 border-bottom" value="{{ $datos['cliente']['direml'] }}">
                </div>
            </div>
        </fieldset>
        @endif
        @if(isset($datos["vendedor"]))
        <fieldset class="border-top">
            <legend class="d-inline-block" style="width: auto;">INFORMACIÓN</legend>
            <div class="row">
                <div class="col-12 col-md-6 text-right"><strong class="text-uppercase">código</strong></div>
                <div class="col-12 col-md-6">{{ $datos["vendedor"]["vnddor"] }}</div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 text-right">
                    <strong class="text-uppercase">CUIT</strong>
                </div>
                <div class="col-12 col-md-6">{{ str_replace("VND_","",$datos["datos"]["username"]) }}</div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 text-right"><strong class="text-uppercase">teléfono</strong></div>
                <div class="col-12 col-md-6">{{ $datos["vendedor"]["nrotel"] }}</div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 text-right"><strong class="text-uppercase">email</strong></div>
                <div class="col-12 col-md-6">{{ $datos["vendedor"]["mail"] }}</div>
            </div>
        </fieldset>
        @endif
        @if(isset($datos["cliente"]))
        <div class="row mt-5 d-none" id="divComentario">
            <div class="col-12 col-md-6 text-right"><strong class="text-uppercase">comentarios</strong></div>
            <div class="col-12 col-md-6">
                <textarea name="comentario" placeholder="Comentario" class="form-control"></textarea>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                <button onclick="editar(this)" type="button" class="btn btn-success px-5 text-uppercase">editar datos<i class="fas ml-3 fa-pencil-alt"></i></button>
                <button type="submit" class="d-none btn btn-primary px-5 text-uppercase">enviar datos<i class="fas fa-paper-plane ml-3"></i></button>
            </div>
        </div>
        @endif
        </form>
    </div>
</div>

@push('scripts_distribuidor')
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
verificar = function(t, ver) {
    let valor1 = $(t).val();
    let valor2 = $(`#${ver}`).val();
    if(valor1 == "" || valor2 == "")
        return false;
    if(valor1 != valor2) {
        $("#btnConfirmar").attr("disabled", true);
        $.notify({
            message: 'Las contraseñas no coinciden' 
        },{
            type: 'danger'
        });
    } else
        $("#btnConfirmar").removeAttr("disabled");
};

editar = function(t) {
    $(t).closest("form").find("input").removeAttr("disabled");
    $(t).find(" + button").removeClass("d-none");
    $(t).addClass("d-none");
    $("#datosNo").css({
        opacity:.5
    });
    $("#divComentario").removeClass("d-none");
};
changePass = function(t) {
    let idForm = t.id;
    let url = t.action;
    let promise = new Promise(function (resolve, reject) {
        let formElement = document.getElementById(idForm);
        let request = new XMLHttpRequest();
        let formData = new FormData(formElement);
        
        request.responseType = 'json';
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open( "POST", url );
        xmlHttp.onload = function() {
            resolve(xmlHttp.response);
        }
        xmlHttp.send( formData );
    });
    promiseFunction = () => {
        promise
            .then(function(data) {
                try {
                    if(typeof data == "string")
                        data = JSON.parse(data);   
                } catch (error) {
                    
                }
                if(data.estado !== undefined) {

                    if(parseInt(data.estado) == 1) {
                        alertify.success("Contraseña cambiada");
                        location.reload();
                    else if(parseInt(data.estado) == 2) {
                        alertify.warning(data.mssg);
                    } else
                        alertify.error(data.mssg);
                } else 
                    alertify.error("Ocurrió un error en el envio. Reintente");
            }
    )};
    alertify.warning("Espere...");
    promiseFunction();
};
enviar = function(t) {
    let idForm = t.id;
    let url = t.action;
    let promise = new Promise(function (resolve, reject) {
        let formElement = document.getElementById(idForm);
        let request = new XMLHttpRequest();
        let formData = new FormData(formElement);
        
        request.responseType = 'json';
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open( "POST", url );
        xmlHttp.onload = function() {
            resolve(xmlHttp.response);
        }
        xmlHttp.send( formData );
    });
    promiseFunction = () => {
        promise
            .then(function(data) {
                if(parseInt(data) == 1) {
                    alertify.success("Datos enviados");
                    location.reload();
                } else 
                    alertify.error("Ocurrió un error en el envio. Reintente");
            }
    )};
    alertify.warning("Espere...");
    promiseFunction();
};
</script>
@endpush