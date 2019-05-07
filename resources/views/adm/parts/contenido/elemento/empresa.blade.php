<div class="alert alert-warning" role="alert">
    <h4 class="alert-heading">Contenido {{strtoupper($seccion)}}</h4>
    <p>Desde esta sección puede asignar qué elementos mostrar en la vista. Cada vista tiene características y elementos únicos. Seleccione estos en el selector SECCIONES.</p>
    <hr>
    <p class="mb-0"><strong>Elementos:</strong> slider</p>
</div>
<div id="wrapper-form" class="mt-2">
    <div class="card">
        <div class="card-body">
            <form id="form" class="pt-2" action="{{ url('/adm/contenido/' . $seccion . '/update') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="container-form"></div>
                <div class="row mt-2 pt-2 border-top">
                    <div class="col-12">
                        <button type="button" id="btnNumeros" onclick="numeros(this)" class="btn btn-dark mx-auto d-block text-uppercase">números<i class="fas fa-plus"></i></button>
                        <div class="container-button move separacion"></div>
                    </div>
                </div>
                <div class="row mt-2 pt-2 border-top">
                    <div class="col-12">
                        <button type="button" id="btnAnios" onclick="anios(this)" class="btn btn-warning mx-auto d-block text-uppercase">años<i class="fas fa-plus"></i></button>
                        <div class="container-button move card-columns"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts_distribuidor')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="//cdn.ckeditor.com/4.7.3/full/ckeditor.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    const srcIMG = "{{ asset('images/general/no-img.png') }}";
    $(document).on("ready",function() {
        $(".ckeditor").each(function () {
            CKEDITOR.replace( $(this).attr("name") );
        });
    });
    let date = new Date();
    let anioSUP = date.getFullYear();
    let anioINF = 1960;
    window.anioRANGO = {};
    for( let i = anioINF ; i <= anioSUP ; i++ )
        window.anioRANGO[i] = i;
    window.pyrus = new Pyrus("empresa", null, srcIMG);
    window.contenido = @json($contenido);
    
    /** ------------------------------------- */
    init = function(callbackOK) {
        console.log("CONSTRUYENDO FORMULARIO Y TABLA");
        /** */
        $("#form .container-form").html(window.pyrus.formulario());

        $('#page').val(window.contenido.data.PAGE).trigger("change");
        setTimeout(() => {
            callbackOK.call(this);
        }, 50);
    }
    removeDefaut = function(t) {
        $(t).closest(".card").remove();
    }
    /** ------------------------------------- */
    /** ------------------------------------- */
    numeros = function( t, data = null ) {//btnNumeros
        let target = $(t).parent().find(".container-button");
        let pyrusNumero = new Pyrus("empresa_numeros");

        if( window.numerosEmpresa === undefined ) window.numerosEmpresa = 0;
        window.numerosEmpresa ++;
        card = "";
        card += '<div class="card bg-light">';
            card += '<div class="card-body p-2 position-relative">';
                card += '<i onclick="removeDefaut(this);" class="far fa-trash-alt bg-danger text-white position-absolute"></i>';
                card += pyrusNumero.formulario(window.numerosEmpresa, "numero");
            card += '</div>';
        card += '</div>';
        target.append(card);

        if( data !== null ) {
            $(`#numero_numero_${window.numerosEmpresa}`).val( data.N );
            $(`#numero_texto_${window.numerosEmpresa}`).val( data.T );
        }
    }
    /** ------------------------------------- */
    anios = function( t, data = null ) {//btnAnios
        let target = $(t).parent().find(".container-button");
        let pyrusAnios = new Pyrus("empresa_anios",{anio: {TIPO:"OP",DATA: window.anioRANGO}});

        if( window.aniosEmpresa === undefined ) window.aniosEmpresa = 0;
        window.aniosEmpresa ++;
        card = "";
        card += '<div class="card bg-light">';
            card += '<div class="card-body p-2 position-relative">';
                card += '<i onclick="removeDefaut(this);" class="far fa-trash-alt bg-danger text-white position-absolute"></i>';
                card += pyrusAnios.formulario(window.aniosEmpresa, "anios");
            card += '</div>';
        card += '</div>';
        target.append(card);
        //
        CKEDITOR.replace(`anios_texto_${window.aniosEmpresa}`);

        if( data !== null ) {
            target.find("> div:last-child select").val(data.A).trigger("change");
            target.find("> div:last-child .ckeditor").val(data.T)
        }
    }
    /** */
    /** ------------------------------------- */
    /** */
    init(function() {
        CKEDITOR.instances[`texto_es`].setData(window.contenido.data.CONTENIDO.es.texto);
        CKEDITOR.instances[`vision_es`].setData(window.contenido.data.CONTENIDO.es.vision.TEX);
        CKEDITOR.instances[`mision_es`].setData(window.contenido.data.CONTENIDO.es.mision.TEX);
        $(`[name="TIT_vision_es"]`).val(window.contenido.data.CONTENIDO.es.vision.TIT);
        $(`[name="TIT_mision_es"]`).val(window.contenido.data.CONTENIDO.es.mision.TIT);

        for(let x in window.contenido.data.CONTENIDO.es.fechas)
            anios( $("#btnAnios"), { A: x, T: window.contenido.data.CONTENIDO.es.fechas[x] } );
        window.contenido.data.CONTENIDO.es.numeros.forEach( function( e ) {
            numeros( $("#btnNumeros"), e );
        });
    });
    
    /** ------------------------------------- */
    $("#btnNumeros + div").sortable({
        axis: "y",
        revert: true,
        scroll: false,
        placeholder: "sortable-placeholder",
        cursor: "move"
    }).disableSelection();
    $("#btnAnios + div").sortable({
        revert: true,
        scroll: false,
        placeholder: "sortable-placeholder",
        cursor: "move"
    }).disableSelection();
</script>
@endpush