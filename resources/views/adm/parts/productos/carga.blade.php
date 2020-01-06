<div class="position-fixed w-100 h-100 bg-light d-none justify-content-center align-items-center" style="left: 0; top: 0;" id="mascara">
    <div class="d-flex align-items-center">
        <div class="spinner-grow text-primary mr-2" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        ACTUALIZANDO
        <small class="badge badge-warning shake-constant shake-chunk text-uppercase ml-2">espere</small>
    </div>
</div>
<h3 class="title">{{$title}}</h3>

<section class="mt-3">
    <div class="container-fluid">
        <h3 class="text-right">
            Últimos cambios<br/>
        </h3>
        <p class="text-right">{!! $cambios !!}</p>


        <h1>Archivos subidos</h1>
        <form id="form" onsubmit="event.preventDefault(); actualizarArchivos(this);" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <ul>
        <?php
            foreach (new DirectoryIterator('file') as $file) {
                if($file->isDot()) continue;
                $a = "{$file->getFilename()}";
                echo "<li class='mt-2'>{$a} <input type='hidden' name='nombre[]' value='{$a}'/><input type='file' name='archivos[]' accept='.dbf,.DBF'/></li>";
            }
        ?>
        </ul>
        <button type="submit" class="btn btn-primary text-uppercase px-5">cargar</button>
        </form>
        <hr>
        <h1>Actualizar información</h1>
        <ul>
            <li><a onclick="event.preventDefault(); actualizar(this, 'ojo');" class="text-primary" href="{{ route('productos.actualizar', ['id' => 'producto']) }}">Productos</a> (cnv_precios) - Producto, Modelo, Marca, Familia y Parte</li>
            <li><a onclick="event.preventDefault(); actualizar(this);" class="text-primary" href="{{ route('productos.actualizar', ['id' => 'transporte']) }}">Transportes</a> (TRALST)</li>
            <li><a onclick="event.preventDefault(); actualizar(this);" class="text-primary" href="{{ route('productos.actualizar', ['id' => 'vendedores']) }}">Vendedores</a> (cnv_Vendedores)</li>
            <li><a onclick="event.preventDefault(); actualizar(this);" class="text-primary" href="{{ route('productos.actualizar', ['id' => 'clientes']) }}">Clientes</a> (cnv_clientes)</li>
            <li><a onclick="event.preventDefault(); actualizar(this);" class="text-primary" href="{{ route('productos.actualizar', ['id' => 'usuarios']) }}">Empleados</a> (USR_EMPLEADOS)</li>
        </ul>
    </div>
</section>

@push('scripts_distribuidor')
<script>
actualizarArchivos = function(t) {
    let flag = 1;
    $("#form").find("input[type='file']").each(function(e) {
        if($(this).val() != "")
            flag = 0;
    });
    if(flag) {
        alertify.error('No agregó ningún archivo para subir');
        return false;
    }
    alertify.confirm("ATENCIÓN","¿Seguro de actualizar archivos?<br><p class='text-muted mb-0' style='font-size:15px'>El nombre debe ser idéntico al que se encuentra, caso contrario se obviara.<br/>Solo serán reemplazados los elementos seleccionados.</p>",
        function() {
            document.getElementById("form").submit();
        },
        function() {
            alertify.error('Cancelado');
        }
    ).set('labels', {ok:'Confirmar', cancel:'Cancelar'});
}
actualizar = function(t, ojo = null) {
    let url = $(t).attr("href");
    alertify.confirm("ATENCIÓN","¿Seguro de actualizar la información?<br>Una vez que comience el proceso no debe ser detenido o cerrado el navegador.",
        function() {
            $("#mascara").removeClass("d-none").addClass("d-flex");
            let promise = new Promise(function (resolve, reject) {
                let formData = new FormData();
                let xmlHttp = new XMLHttpRequest();
                formData.append("_token","{{ csrf_token() }}");

                xmlHttp.open( "POST", url, true );
                xmlHttp.onload = function() {
                    resolve(xmlHttp.response);
                }
                xmlHttp.send( formData );
            });

            promiseFunction = () => {
                promise
                    .then(function(data) {
                        if( ojo !== null ) {
                            timeout = 1000 * 60 * 8;
                            setTimeout(() => {
                                url = `{{ url('/adm/productos/count') }}`;
                                xmlHttp = new XMLHttpRequest();
                                xmlHttp.open( "GET", url, true );
                                xmlHttp.onload = function() {
                                    console.log(xmlHttp)
                                    alertify.success(`Registros totales: ${xmlHttp.response}`);
                                    $("#mascara").removeClass("d-flex").addClass("d-none");
                                }
                                xmlHttp.send( null );
                            }, timeout);
                        } else {
                            alertify.success(`Registros totales: ${data}`);
                            $("#mascara").removeClass("d-flex").addClass("d-none");
                        }
                    })
            };
            promiseFunction();
        },
        function(){
            alertify.error('Cancelado');
        }
    ).set('labels', {ok:'Confirmar', cancel:'Cancelar'});
};
</script>
@endpush