
<section class="mt-3">
    <div class="container-fluid">
        <div class="alert alert-primary" role="alert">
            Programa ejecutable (exe) de Ventor - <strong>INSTALADOR_VENTOR</strong>
        </div>
        <div style="" id="wrapper-form" class="mt-2">
            <div class="card">
                <div class="card-body">
                    <form id="form" class="" action="{{ url('/adm/empresa/programa/update') }}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="container-form"></div>
                        <p class="text-center mt-3">
                            <small class="text-uppercase">
                            @if(empty($programa))
                            sin EXE
                            @else
                            EXE subido
                            @endif
                            </small>
                        </p>
                        <button type="submit" class="btn btn-success mx-auto d-block text-uppercase px-5 mt-3">subir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts_distribuidor')
<script>
    const src = "{{ asset('images/general/no-img.png') }}";

    window.pyrus = new Pyrus("programa", null, src);
    
    
    /** ------------------------------------- */
    init = function() {
        console.log("CONSTRUYENDO FORMULARIO Y TABLA");
        /** */
        $("#form .container-form").html(window.pyrus.formulario());
    }
    /** */
    init();
</script>
@endpush