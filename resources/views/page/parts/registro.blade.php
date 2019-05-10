<div class="wrapper-formulario bg-white border-top-0 py-5">
    <div class="container">
        <h2 class="title">Registro</h2>
        <form action="{{ route('registro') }}" method="post">
            @csrf
            <div class="row justify-content-center mt-4">
                <div class="col-12 col-md-8" id="formulario"></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <button class="btn btn-primary text-uppercase">registrarse</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push("scripts_distribuidor")
<script>
    window.pyrus = new Pyrus("formulario_registro");
    $("#formulario").html(window.pyrus.formulario());

</script>
@endpush