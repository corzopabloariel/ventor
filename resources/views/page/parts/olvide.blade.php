<div class="wrapper-contacto py-5">
    <div class="container py-5">
        <h3 style="font-weight: lighter;font-size: 35px;" class="title">Recupera tu cuenta</h3>
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-md-5">
                <div class="card bg-light">
                    <div class="card-body">
                        <form action="" id="form" method="post" onsubmit="event.preventDefault(); buscar(this);">
                            @csrf
                            <div id="formData">
                                <p class="card-text">Ingresa tu CUIT para buscar tu cuenta.</p>
                                <input type="hidden" name="tipo" id="tipo" value="primero">
                                <div class="row">
                                    <div class="col-12">
                                        <input type="text" style="background: transparent;" required name="cuit" placeholder="CUIT" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <button type="submit" class="btn btn-primary rounded-0">Buscar</button>
                                        <button type="button" onclick="volver(this);" class="btn ml-2 btn-secondary rounded-0" style="background-color: #6c757d;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src='https://www.google.com/recaptcha/api.js'></script>

<script>
volver = function(t) {
    window.location = "{{ route('index') }}";
};
buscar = function(t) {
    let idForm = t.id;
    let url = t.action;
    let notify = null;
    if($("#tipo").val() == "primero") {
        notify = $.notify('Espere. Buscando información. No cierre la página...', {
            allow_dismiss: false,
            showProgressbar: false
        });
    } else {
        notify = $.notify('Espere. Cambiando contraseña. No cierre la página...', {
            allow_dismiss: false,
            showProgressbar: false
        });
    }
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
                if(typeof data == "string")
                    data = JSON.parse(data);
                if(data.estado !== undefined) {
                    if($("#tipo").val() == "primero") {
                        if(data.dato === null) {
                            //alertify.error("Dato no encontrados");
                            notify.update({'type': 'warning', 'message': 'Datos no encontrados'});
                            return false;
                        }
                        notify.update({'type': 'success', 'message': 'Dato encontrado'});
                        html = "";
                        html += `<input type="hidden" name="tipo" id="tipo" value="segundo">`;
                        html += `<input type="hidden" name="usuarioID" value="${data.dato.id}">`;
                        if(data.dato.email == "" || data.dato.email === null) {
                            html += `<div class="row">`;
                                html += `<div class="col-12">`;
                                    html += `<div class="alert alert-warning" role="alert">`;
                                        html += `No hay email asociado al CUIT <strong>${data.dato.username}</strong>`
                                    html += `</div>`;
                                html += `</div>`;
                            html += `</div>`;
                        }
                        html += `<div class="row">`;
                            html += `<div class="col-12">`;
                                html += `<p class="mb-0"><strong>NOMBRE:</strong> ${data.dato.name}</p>`;
                            html += `</div>`;
                        html += `</div>`;
                        
                        html += `<div class="row">`;
                            html += `<div class="col-12">`;
                                html += `<input onblur="verificar(this,'pass_2')" type="password" style="background: transparent;" required name="password" placeholder="Contraseña nueva" id="pass_1" class="form-control">`;
                            html += `</div>`;
                        html += `</div>`;
                        html += `<div class="row">`;
                            html += `<div class="col-12">`;
                                html += `<input onblur="verificar(this,'pass_1')" type="password" style="background: transparent;" required name="password2" placeholder="Repita contraseña nueva" id="pass_2" class="form-control">`;
                            html += `</div>`;
                        html += `</div>`;

                        html += `<div class="row">`;
                            html += `<div class="col-12 d-flex">`
                                html += `<button type="submit" disabled id="btnConfirmar" class="btn btn-primary rounded-0">Cambiar</button>`;
                                html += `<button type="button" onclick="volver(this);" class="btn ml-2 btn-secondary rounded-0" style="background-color: #6c757d;">Cancelar</button>`;
                            html += `</div>`;
                        html += `</div>`;
                        $("#formData").html(html);
                    } else {
                        if(parseInt(data.estado) == 1) {
                            notify.update({'type': 'success', 'message': 'Contraseña cambiada'});
                            volver(null);
                        } else
                            notify.update({'type': 'error', 'message': 'Ocurrió un error'});
                    }
                } else {
                    notify.update({'type': 'error', 'message': 'Ocurrió un error'});
                }
            }
    )};
    promiseFunction();
};

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
validar = function(t, marca = true, visible = true) {
    let flag = 1;
    $(t).find('*[required]').each(function() {
        if($(this).is(":visible")) {
            flagI = true;
            if($(this).attr("type") !== undefined) {
                if($(this).attr("type") == "file" || $(this).attr("type") == "date")
                    flagI = false;
            }
            if(flagI) {
                if($(this).is(":invalid") || $(this).val() == "") {
                    flag = 0;
                    if(marca) $(this).addClass("has-error");
                }
            }
        }
    });
    return flag;
};
validarSTRING = function(t) {
    let string = "";
    $(t).find('*[required]').each(function() {
        if($(this).is(":invalid") || $(this).val() == "") {
            flag = true;
            if($(this).attr("type") !== undefined) {
                if($(this).attr("type") == "file" || $(this).attr("type") == "date")
                    flag = false;
            }
            if(flag) {
                if($(this).is(":invalid") || $(this).val() == "") {
                    if(string != "") string += ", ";
                    if($(this).attr("placeholder") === undefined)
                        string += $(this).data("placeholder");
                    else {
                        t = $(this).attr("placeholder");
                        if(t.indexOf("*") >= 0)
                            t = t.replace(" *","");
                        string += t;
                    }
                }
            }
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
};

</script>

@endpush