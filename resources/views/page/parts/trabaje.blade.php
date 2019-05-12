<div class="wrapper-trabaje py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-5">
                <h2 class="title text-uppercase">trabaje con nosotros</h2>
            </div>
            <div class="col-12 col-md-7">
                <blockquote class="blockquote bg-light py-2 px-3 border-left">
                    <p class="title mb-0">Se precisa</p>
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
        
        <div class="row mt-5">
            <div class="col-12 col-md-4">
                <h3 class="title text-uppercase">trabajo y educación</h3>
            </div>
            
            <div class="col-12 col-md-8">
                <a class="text-primary">+ Añadir Educación</a>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-12 col-md-4">
                <h3 class="title text-uppercase">redes sociales</h3>
            </div>
            <div class="col-12 col-md-8">
                <div class="redes"></div>
                <a class="text-primary">+ Añadir Red Social</a>
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
                <button class="btn px-5 text-white text-uppercase">enviar</button>
            </div>
        </div>
    </div>
</div>
@push("scripts_distribuidor")
<script>
    window.pyrus = new Pyrus("formulario_recursos");
    window.redes = new Pyrus("formulario_redes")
    $("#formulario").html(window.pyrus.formulario());
    $(".redes").html(window.redes.formulario())

</script>
@endpush