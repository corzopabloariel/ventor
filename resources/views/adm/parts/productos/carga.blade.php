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
        <h1>Archivos subidos</h1>
        <ul>
        <?php
            foreach (new DirectoryIterator('file') as $file) {
                if($file->isDot()) continue;
                $a = "{$file->getFilename()}";
                echo "<li>{$a} <a class='text-primary' href='subir/{$a}'><i class='ml-2 fas fa-edit'></i></a></li>";
            }
        ?>
        </ul>
        <hr>
        <h1>Actualizar información</h1>
        <ul>
            <li><a onclick="event.preventDefault(); actualizar(this);" class="text-primary" href="{{ route('productos.actualizar', ['id' => 'producto']) }}">Productos</a> - Producto, Modelo, Marca, Familia y Parte</li>
            <li><a onclick="event.preventDefault(); actualizar(this);" class="text-primary" href="{{ route('productos.actualizar', ['id' => 'transporte']) }}">Transportes</a></li>
            <li><a onclick="event.preventDefault(); actualizar(this);" class="text-primary" href="{{ route('productos.actualizar', ['id' => 'vendedores']) }}">Vendedores x</a></li>
            <li><a onclick="event.preventDefault(); actualizar(this);" class="text-primary" href="{{ route('productos.actualizar', ['id' => 'clientes']) }}">Clientes x</a></li>
            <li><a onclick="event.preventDefault(); actualizar(this);" class="text-primary" href="{{ route('productos.actualizar', ['id' => 'usuarios']) }}">Empleados x</a></li>
        </ul>
    </div>
</section>

@push('scripts_distribuidor')
<script>
actualizar = function(t) {
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
                    console.log(xmlHttp)
                    resolve(xmlHttp.response);
                }
                xmlHttp.send( formData );
            });

            promiseFunction = () => {
                promise
                    .then(function(data) {
                        console.log(data);
                        alertify.success(`Registros totales: ${data}`);
                        $("#mascara").removeClass("d-flex").addClass("d-none");
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