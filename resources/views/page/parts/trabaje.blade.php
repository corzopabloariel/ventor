<div class="wrapper-trabaje py-5">
    <div class="container">
        <h2 class="title text-uppercase">trabaje con nosotros</h2>
        <div class="row">
            <div class="col-12 col-md-4">
                <h3 class="title text-uppercase">datos personales</h3>
            </div>
            <div class="col-12 col-md-8">
                <div id="formulario"></div>
                <p class="mt-4">Seleccione los rubros a los que desea postularse</p>
                <div class="d-flex mt-4 postulacion">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" value="vendedor" name="postular">
                            Vendedor en zona
                        </label>
                    </div>
                    <div class="form-check ml-5">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" value="atencionCliente" name="postular">
                            Atención al cliente (CABA)
                        </label>
                    </div>
                </div>
                <div class="d-flex mt-4 postulacion">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" value="administracionCABA" name="postular">
                            Administración (CABA)
                        </label>
                    </div>
                    <div class="form-check ml-5">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" value="otroCABA" name="postular">
                            Otro (CABA)
                        </label>
                    </div>
                </div>
                <div class="d-flex mt-4 postulacion">
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
    </div>
</div>
@push("scripts_distribuidor")
<script>
    window.pyrus = new Pyrus("formulario_recursos");
    $("#formulario").html(window.pyrus.formulario());

</script>
@endpush