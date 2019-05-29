<div class="wrapper-trabaje py-5">
    <div class="container">
        <form action="{{ url('/form/trabaje') }}" novalidate id="form" onsubmit="event.preventDefault(); enviar(this);" method="post">
            @csrf
            <div class="row">
                <div class="col-12 col-md-5">
                    <h2 class="title text-uppercase">trabaje con nosotros</h2>
                    <p class="text-mutted"><span style="color: #FF0000">*</span> Campos Obligatorios</p>
                </div>
                <div class="col-12 col-md-7">
                    <blockquote class="blockquote bg-light py-2 px-3 border-left">
                        <p class="title mb-0">Búsqueda activa</p>
                        <ol class="mb-0 pl-0" style="list-style-position: inside">
                            @foreach($datos["trabajos"] AS $t)
                            <li>{{ $t["titulo"] }} {{ $t["zona"] }} @if($t["in_zone"])(Domicilio en zona)@endif</li>
                            @endforeach
                        </ol>
                    </blockquote>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <h3 class="title text-uppercase">datos personales</h3>
                </div>
                <div class="col-12 col-md-8">
                    <div id="formulario"></div>
                    <p class="mt-4">Seleccione los rubros a los que desea postularse</p>
                    <div class="mt-4 postulacion">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" value="vendedor" name="postular">
                                Vendedor en zona
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" value="atencionCliente" name="postular">
                                Atención al cliente (CABA)
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" value="administracionCABA" name="postular">
                                Administración (CABA)
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" value="otroCABA" name="postular">
                                Otro (CABA)
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" value="vendedor" name="postular">
                                Producción
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8" id="formulario"></div>
            </div>
            
            <div class="row mt-5">
                <div class="col-12 col-md-4">
                    <h3 class="title text-uppercase">trabajo y educación</h3>
                </div>
                
                <div class="col-12 col-md-8">
                    <h3 class="titleC">Curriculum Vitae</h3>
                    <div class="curriculum"></div>

                    <h3 class="title text-uppercase mt-5">trabajo</h3>
                    <div class="trabajos"></div>
                    <a class="text-primary mt-2 d-inline-block" style="cursor: pointer" onclick="trabajoAdd(this)">+ Añadir Trabajo</a>

                    <h3 class="title text-uppercase mt-5">educación</h3>
                    <div class="educaciones"></div>
                    <a class="text-primary mt-2 d-inline-block" style="cursor: pointer" onclick="educacionAdd(this)">+ Añadir Educación</a>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-12 col-md-4">
                    <h3 class="title text-uppercase">redes sociales</h3>
                </div>
                <div class="col-12 col-md-8">
                    <div class="redes"></div>
                    <a class="text-primary mt-2 d-inline-block" style="cursor: pointer" onclick="redesAdd(this)">+ Añadir Red Social</a>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-12 col-md-4">
                    <h3 class="title text-uppercase">expectativas personales</h3>
                </div>
                <div class="col-12 col-md-8">
                    <div class="row">
                        <div class="col-12">
                            <input value="" name="remuneracion" id="remuneracion" class="form-control  texto-text" type="text" placeholder="Ingresar Remuneración Pretendida (la remuneración a escoger es en bruto)">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <textarea name="mensaje" id="mensaje" class="form-control" placeholder="Mensaje Adicional"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5 justify-content-end">
                <div class="col-12 col-md-8">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="g-recaptcha" data-sitekey="6LeFv6IUAAAAAGE-MtiFauHZVvNN3CEjpD71ZJT1"></div>
                        </div>
                        <div class="col-12 col-md-6 d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" required data-placeholder="Términos y condiciones" type="checkbox" value="1" name="terminos" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Acepto los términos y condiciones de privacidad
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5 justify-content-end">
                <div class="col-12 col-md-8">
                    <button type="submit" class="btn px-5 text-white text-uppercase">enviar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@push("scripts_distribuidor")
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
    window.pyrus = new Pyrus("formulario_recursos");
    window.redes = new Pyrus("formulario_redes");
    window.trabajos = new Pyrus("formulario_trabajo");
    window.educacion = new Pyrus("formulario_educacion");
    window.curriculum = new Pyrus("formulario_curriculum");
    window.redesID = 1;
    window.trabajosID = 1;
    window.educacionID = 1;
    $("#formulario").html(window.pyrus.formulario());
    $("form .curriculum").html(window.curriculum.formulario());
    $("form .redes").html(window.redes.formulario(window.redesID,"redes"));
    $("form .trabajos").html(`<div class="bg-light p-4 position-relative trabajo"><small onclick="removeThis(this,'.trabajo','¿Eliminar Trabajo?');" class="text-danger position-absolute" style="right:10px;top:10px; z-index:1; cursor: pointer"><i class="fas fa-times"></i> Eliminar</small>${window.trabajos.formulario(window.trabajosID,"trabajos")}</div>`);
    $("form .educaciones").html(`<div class="bg-light p-4 position-relative educacion"><small onclick="removeThis(this,'.educacion','¿Eliminar Educación?');" class="text-danger position-absolute" style="right:10px;top:10px; z-index:1; cursor: pointer"><i class="fas fa-times"></i> Eliminar</small>${window.educacion.formulario(window.educacionID,"educacion")}</div>`);

    redesAdd = function(t) {
        window.redesID ++;
        $("form .redes").append(`<div class="position-relative red"><small onclick="removeThis(this,'.red','¿Eliminar Red Social?');" class="text-danger position-absolute" style="right:0;top:0; z-index:1; cursor: pointer"><i class="fas fa-times"></i> Eliminar</small>${window.redes.formulario(window.redesID,"redes")}</div>`);
    };
    trabajoAdd = function(t) {
        window.trabajosID ++;
        $("form .trabajos").append(`<div class="bg-light p-4 position-relative trabajo"><small onclick="removeThis(this,'.trabajo','¿Eliminar Trabajo?');" class="text-danger position-absolute" style="right:10px;top:10px; z-index:1; cursor: pointer"><i class="fas fa-times"></i> Eliminar</small>${window.trabajos.formulario(window.trabajosID,"trabajos")}</div>`);
    };
    educacionAdd = function(t) {
        window.educacionID ++;
        $("form .educaciones").append(`<div class="bg-light p-4 position-relative educacion"><small onclick="removeThis(this,'.educacion','¿Eliminar Educación?');" class="text-danger position-absolute" style="right:10px;top:10px; z-index:1; cursor: pointer"><i class="fas fa-times"></i> Eliminar</small>${window.educacion.formulario(window.educacionID,"educacion")}</div>`);
    }
    removeThis = function(t,target,mssg) {
        
        alertify.confirm("ATENCIÓN",mssg,
            function(){
                $(t).closest(target).remove();
            },
            function() {}
        ).set('labels', {ok:'Confirmar', cancel:'Cancelar'});
    };
    /**
     * @param id - Elemento a agregar o quitar attr
     */
    readONLY = function(t,id) {
        $(`#${id}`).val("");
        if ( $(`#${id}`).is(':disabled') )
            $(`#${id}`).removeAttr("disabled");
        else
            $(`#${id}`).attr("disabled",true);
    }
    
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
                else
                    string += $(this).attr("placeholder");
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
}
</script>
@endpush