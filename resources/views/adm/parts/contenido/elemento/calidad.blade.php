<div id="wrapper-form" class="mt-2">
    <div class="card">
        <div class="card-body">
            <form id="form" novalidate class="pt-2" action="{{ url('/adm/contenido/' . $seccion . '/update') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
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
    window.pyrus = new Pyrus("calidad");
    window.contenido = @json($contenido);
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
    init = function(callbackOK) {
        console.log("CONSTRUYENDO FORMULARIO Y TABLA");
        /** */
        $("#form .container-form").html(window.pyrus.formulario());

        $('#page').val(window.contenido.data.PAGE).trigger("change");
        setTimeout(() => {
            callbackOK.call(this);
        }, 50);
    }
    /** */
    init(function() {
        CKEDITOR.instances[`texto_principal_es`].setData(window.contenido.data.CONTENIDO.es.principal.texto);
        CKEDITOR.instances[`texto_calidad_es`].setData(window.contenido.data.CONTENIDO.es.calidad.texto);
        CKEDITOR.instances[`texto_garantia_es`].setData(window.contenido.data.CONTENIDO.es.garantia.texto);
        $(`[name="TIT_principal_es"]`).val(window.contenido.data.CONTENIDO.es.principal.titulo);
        $(`[name="SUBTIT_principal_es"]`).val(window.contenido.data.CONTENIDO.es.principal.subtitulo);
        $(`[name="slogan_principal_es"]`).val(window.contenido.data.CONTENIDO.es.principal.slogan);
        $(`[name="TIT_calidad_es"]`).val(window.contenido.data.CONTENIDO.es.calidad.titulo);
        $(`[name="TIT_garantia_es"]`).val(window.contenido.data.CONTENIDO.es.garantia.titulo);
    });
</script>
@endpush