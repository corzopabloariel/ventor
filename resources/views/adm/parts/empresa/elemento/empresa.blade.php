<div style="display: block;" id="wrapper-form" class="">
    <div class="card">
        <div class="card-body">
            <form id="form" novalidate class="pt-2" action="{{ url('/adm/empresa/update') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="row justify-content-center mb-2">
                    <div class="col-md-4 col-12"><button type="submit" class="btn btn-block btn-success text-uppercase text-center">editar</button></div>
                </div>
                <div class="container-form"></div>
            </form>
        </div>
    </div>
</div>
@push('scripts_distribuidor')
<script src="//cdn.ckeditor.com/4.7.3/full/ckeditor.js"></script>
<script>
    $(document).on("ready",function() {
        $(".ckeditor").each(function () {
            CKEDITOR.replace( $(this).attr("name") );
        });
    });
    const src = "{{ asset('images/general/no-img.png') }}";
    window.pyrusImage = new Pyrus("empresa_images", null, src);
    window.pyrusGeneral = new Pyrus("empresa_general");
    window.pyrusDomicilio = new Pyrus("empresa_domicilio");
    window.pyrusTelefono = new Pyrus("empresa_telefono");
    window.pyrusEmail = new Pyrus("empresa_email");
    
    window.datos = @JSON($datos)
    /** ------------------------------------- */
    readURL = function(input, target) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(`#${target}`).attr(`src`,`${e.target.result}`);
            };
            reader.readAsDataURL(input.files[0]);
        }
    };
    /** ------------------------------------- */
    addTelefono = function(t, value = null) {
        let target = $(`#wrapper-telefono`);
        let html = "";
        if(window.telefonoCOUNT === undefined) window.telefonoCOUNT = 0;
        window.telefonoCOUNT ++;

        html += '<div class="col-4 my-2 tel position-relative">';
            html += '<div class="bg-light p-2 border">';
                html += window.pyrusTelefono.formulario(window.telefonoCOUNT,"telefono");
                html += `<i style="line-height:14px; cursor: pointer; right: 5px; top: -10px; padding: 5px;" onclick="$(this).closest('.tel').remove()" class="fas fa-times position-absolute text-white bg-danger rounded-circle"></i>`;
            html += '</div>';
        html += '</div>';
    
        target.append(html);

        if(value !== null) {
            target.find("> div:last-child select").val(value.tipo).trigger("change");
            target.find("> div:last-child input").val(value.telefono);
        }
    }
    
    addEmail = function(t, value = null) {
        let target = $(`#wrapper-email`);
        let html = "";
        if(window.email === undefined) window.email = 0;
        window.email ++;

        html += '<div class="col-4 my-2 tel position-relative">';
            html += '<div class="bg-light p-2 border">';
                html += window.pyrusEmail.formulario(window.email,"email");
                html += `<i style="line-height:14px; cursor: pointer; right: 5px; top: -10px; padding: 5px;" onclick="$(this).closest('.tel').remove()" class="fas fa-times position-absolute text-white bg-danger rounded-circle"></i>`;
            html += '</div>';
        html += '</div>';
    
        target.append(html);
        if(value !== null)
            target.find("> div:last-child input").val(value);
    }
    /** ------------------------------------- */
    init = function(callbackOK) {
        console.log("CONSTRUYENDO FORMULARIO Y TABLA");
        form = "";
        /** */
        form += window.pyrusGeneral.formulario();
        form += `<hr/>`;
        form += `<fieldset>`;
            form += `<legend>Imágenes</legend>`;
            form += window.pyrusImage.formulario();
        form += `</fieldset>`;
        form += `<fieldset>`;
            form += `<legend>Domicilio</legend>`;
            form += window.pyrusDomicilio.formulario();
        form += `</fieldset>`;
        form += '<div class="row justify-content-center pt-3 border-top">';
            form += '<div class="col-md-3 col-12">';
                form += '<button id="btnTelefono" type="button" class="btn btn-block btn-dark text-center text-uppercase" onclick="addTelefono(this)">Teléfono<i class="fas fa-plus ml-2"></i></button>';
            form += `</div>`;
        form += `</div>`;
        form += '<div class="row mt-0" id="wrapper-telefono"></div>';
        
        form += '<div class="row justify-content-center pt-3 border-top">';
            form += '<div class="col-md-3 col-12">';
                form += '<button id="btnEmail" type="button" class="btn btn-block btn-info text-center text-uppercase" onclick="addEmail(this)">Email<i class="fas fa-plus ml-2"></i></button>';
            form += `</div>`;
        form += `</div>`;
        form += '<div class="row mt-0" id="wrapper-email"></div>';

        $("#form .container-form").html(form);
        setTimeout(() => {
            callbackOK.call(this);
        }, 50);
    }
    /** */
    init(function() {
        date = new Date();
        let logo = null, logoFooter = null, favicon = null;
        if( window.datos.images !== null ) {
            logo = `{{ asset('${window.datos.images.logo}') }}?t=${date.getTime()}`;
            logoFooter = `{{ asset('${window.datos.images.logoFooter}') }}?t=${date.getTime()}`;
            if(window.datos.images.favicon !== null)
                favicon = `{{ asset('${window.datos.images.favicon.i}') }}?t=${date.getTime()}`;
        }
        CKEDITOR.instances[`pago`].setData(window.datos.pago);
        CKEDITOR.instances[`banco`].setData(window.datos.banco);
        $(`#src-logo`).attr("src",logo);
        $(`#src-logoFooter`).attr("src",logoFooter);
        $(`#src-favicon`).attr("src",favicon);

        $("#calle").val(window.datos.domicilio.calle);
        $("#altura").val(window.datos.domicilio.altura);
        $("#barrio").val(window.datos.domicilio.barrio);

        window.datos.email.forEach(function(e) {
            addEmail($("#btnEmail"), e);
        });
        console.log(window.datos.telefono)
        for(let x in window.datos.telefono) {
            window.datos.telefono[x].forEach(function(t) {
                addTelefono($("#btnTelefono"),{tipo: x, telefono: t});
            });
        }
    });
</script>
@endpush