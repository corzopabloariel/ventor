@push("styles")
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="{{ asset('css/alertifyjs/alertify.min.css') }}" rel="stylesheet">
@endpush
<div class="wrapper-pedido py-5">
    <div class="container">
        @if(isset($datos["carrito"]))
            <h2 class="title mb-3 text-uppercase">carrito (<span id="cantProductos">0</span>)</h2>
        @else
        <div class="row justify-content-center mt-2 mb-5">
            <div class="col-12 col-md-6">
                <form action="{{ url('buscador/pedido') }}" method="post" class="buscador position-relative">
                    @csrf
                    <button type="submit" class="btn btn-link position-absolute"><i class="fas fa-search"></i></button>
                    <input type="text" name="buscar" value="@if(!empty($datos['buscar'])) {{ $datos['buscar']['buscar'] }} @endif" class="form-control" placeholder="Buscar código, parte, marca, nombre">
                </form>
            </div>
        </div>
        @endif
        <div class="table-responsive">
            <table class="table w-100">
                <thead>
                    @if(!isset($datos["carrito"]))
                    <th></th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th class="text-center">Unidad de Venta</th>
                    <th class="text-right">Precio unitario</th>
                    <th>cantidad de productos</th>
                    <th></th>
                    @else
                    <th style="width:80px;"></th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th class="text-center">Unidad de Venta</th>
                    <th class="text-right">Precio unitario</th>
                    <th class="text-center">cantidad de productos</th>
                    <th class="text-right">subtotal</th>
                    <th class="text-center">eliminar</th>
                    @endif
                </thead>
                <tbody>
                    @foreach($datos["productos"] AS $p)
                    @if(!isset($datos["carrito"]))
                    
                    <tr class="" data-id="{{ $p['id'] }}" data-precio="{{ $p['precio'] }}">
                        <td>
                            <img class="border w-100" src="{{ asset($p['image']) }}" onerror="this.src=''"/>
                        </td>
                        <td>
                            <p class="mb-0">{{ $p["codigo"] }}</p>
                            <p class="mb-0">{{ $p->marca["nombre"] }}</p>
                            {!! $p["nombre"] !!}</td>
                        <td>{!! $p->categoria->getCategoriaEnteroAttribute() !!}</td>
                        <td class="text-center">{{ $p["cantidad"] }}</td>
                        <td class="text-right">$ {{ $p->getPrecio() }}</td>
                        <td data-cantidad><input pattern="[0-9]+" onchange="cambio(this)" type="number" class="form-control text-right" name="" min="0" value="0" step="{{ $p['cantidad'] }}" id=""></td>
                        <td class="text-center"><button onclick="pedido(this)" type="button" class="btn btn-secondary text-uppercase">pedir</button></td>
                    </tr>
                    @else
                    <tr class="d-none" data-id="{{ $p['id'] }}" data-precio="{{ $p['precio'] }}">
                        <td style="">
                            <img class="border w-100" src="{{ asset($p['image']) }}" onerror="this.src=''"/>
                        </td>
                        <td>
                            <p class="mb-0">{{ $p["codigo"] }}</p>
                            <p class="mb-0">{{ $p->marca["nombre"] }}</p>
                            {!! $p["nombre"] !!}</td>
                        <td>{!! $p->categoria->getCategoriaEnteroAttribute() !!}</td>
                        <td class="text-center">{{ $p["cantidad"] }}</td>
                        <td class="text-right">$ {{ $p->getPrecio() }}</td>
                        <td data-cantidad style="width: 140px;"><input onchange="cambio(this)" type="number" class="form-control text-right" name="" min="" step="{{ $p['cantidad'] }}" id=""></td>
                        <td class="text-right" data-subtotal class="text-right">$ </td>
                        <td class="text-center"><button onclick="eliminar(this)" type="button" class="btn btn-link text-uppercase" style="color:#9B9B9B"><i class="far fa-times-circle"></i></button></td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        @if(isset($datos["carrito"]))
        <div class="row mt-3">
            <div class="col-12 col-md-7 obs">
                <p>Observaciones</p>
                <textarea name="observaciones" id="observaciones" rows="3" class="form-control" placeholder="Texto de nota de pedido, condiciones de pago"></textarea>
            </div>
            <div class="col-12 col-md-5 valor">
                <p class="mb-2 d-flex w-100 justify-content-between">Subtotal (no incluye IVA)<span id="subtotal">$ 0</span></p>
                @php
                $descuento = auth()->guard('client')->user()["descuento"];
                $descuento *= 100;
                @endphp
                <p class="mb-4 d-flex w-100 justify-content-between"><span>Bonificacion (<span id="bonificacionCliente">{{$descuento}}%</span>)</span> <span id="bonificacion">$ 0</span></p>
                <p class="total border-bottom border-dark mb-1 d-flex w-100 align-items-center justify-content-between">Total (c/ bonificación) <span id="total">$ 0</span></p>
                <p style="color: #C01939; font-size: 13px mb-0">El total no incluye IVA ni impuestos internos</p>

                <div class="row">
                    <div class="col-12 col-md-6">
                        <button onclick="window.location='{{ route('pedido') }}'" type="button" class="btn btn-block text-center px-3 text-uppercase btn-outline-secondary">continuar pedido</button>
                    </div>
                    <div class="col-12 col-md-6">
                        <button onclick="pedir(this)" type="button" class="btn btn-block text-center px-3 text-uppercase btn-secondary">realizar pedido</button>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row col-12 justify-content-center">
            {{ $datos["productos"]->onEachSide(5)->links() }}
        </div>
        @endif
    </div>
</div>
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{ asset('js/alertify.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-input-spinner.js') }}"></script>
<script>
    $(document).ready(function() {
        
        if($("input[type='number']").length) {
            let config = {
                decrementButton: '<i class="fas fa-minus"></i>',
                incrementButton: '<i class="fas fa-plus"></i>',
                buttonsClass: "btn-outline-secondary btn-sm",
                buttonsWidth: "1.5rem",
            }
            $( "input[type='number']" ).inputSpinner(config);
        }
    });
    formatter = new Intl.NumberFormat('es-AR', {
        style: 'currency',
        currency: 'ARS',
    });

    if(localStorage.productos !== undefined) {
        window.productos = JSON.parse(localStorage.productos);
        window.normal = 1;

        for(let x in window.productos) {
            $(`table *[data-id="${x}"]`).removeClass("d-none");
            $(`table *[data-id="${x}"]`).find("*[data-cantidad] input").val(window.productos[x].cantidad).trigger("change");
        }
        delete window.normal;
        if(Object.keys(window.productos).length > 0) {
            if(!$("nav [data-carrito] > a > span").length) 
                $("nav [data-carrito] > a").append(`<span class="ml-1">(${Object.keys(window.productos).length})</span>`);
            if($("#cantProductos").length)
                $("#cantProductos").text(Object.keys(window.productos).length);
        }
    }
    pedido = function(t) {
        let id = $(t).closest("tr").data("id");
        let precio = $(t).closest("tr").data("precio");
        let cantidad = $(t).closest("tr").find("*[data-cantidad] input").val();
        if(window.productos === undefined)
            window.productos = {};
        if(window.productos[id] === undefined)
            window.productos[id] = {cantidad: 0,precio:precio};
        window.productos[id].cantidad = cantidad;

        localStorage.setItem("productos",JSON.stringify(window.productos));
        alertify.success(`${window.productos[id].cantidad} u. seleccionadas`);

        
        if(Object.keys(window.productos).length > 0) {
            if(!$("nav [data-carrito] > a > span").length) 
                $("nav [data-carrito] > a").append(`<span class="ml-1">(${Object.keys(window.productos).length})</span>`);
            else
                $("nav [data-carrito] > a > span").text(`(${Object.keys(window.productos).length})`);
        }
    }
    eliminar = function(t) {
        let id = $(t).closest("tr").data("id");
        
        alertify.confirm("ATENCIÓN","¿Eliminar registro?",
            function(){
                let precio = parseFloat($(t).closest("tr").data("precio"));
                let cantidad = parseInt($(t).closest("tr").find("td[data-cantidad] input").val());
                window.sumaTotal -= precio * cantidad;
                if($("#subtotal").length) {
                    $("#subtotal").text(formatter.format(window.sumaTotal));
                    $("#bonificacion").text(formatter.format(window.sumaTotal * window.data.descuento * (-1)));
                    $("#total").text(formatter.format(window.sumaTotal + (window.sumaTotal * window.data.descuento * (-1))));
                }
                $(t).closest("tr").remove();
                delete window.productos[id];
                localStorage.setItem("productos",JSON.stringify(window.productos));

                if($("#cantProductos").length)
                    $("#cantProductos").text(Object.keys(window.productos).length);
                $("nav [data-carrito] > a > span").text(`(${Object.keys(window.productos).length})`);
                if(Object.keys(window.productos).length == 0) {
                    if($("nav [data-carrito] > a > span").length) 
                        $("nav [data-carrito] > a > span").remove();
                }
            },
            function() {}
        ).set('labels', {ok:'Confirmar', cancel:'Cancelar'});
    }
    function cambio(t) {
        let id = parseInt($(t).closest("tr").data("id"));
        if($(t).closest("tr").data("precio") == "") {
            $(t).closest("tr").find("*[data-subtotal]").text(formatter.format(0));
            return false;
        }
        let precio = parseFloat($(t).closest("tr").data("precio"));
        let cantidad = parseInt($(t).val());

        let step = parseInt($(t).attr("step"));
        if(cantidad % step === 0) {
            if(window.sumaTotal === undefined) window.sumaTotal = 0.0;
            /*------ RESTO PRIMERO */
            if(window.normal === undefined)
            window.sumaTotal -= precio * window.productos[id].cantidad;
            /*------ SUMO EL NUEVO VALOR */
            window.sumaTotal += precio * cantidad;
            window.productos[id].cantidad = cantidad;
            localStorage.setItem("productos",JSON.stringify(window.productos));

            $(t).closest("tr").find("*[data-subtotal]").text(formatter.format(precio * cantidad));
        } else {
            alertify.notify(`Cantidad no permitida. Solo múltiplos de ${step}`, 'warning');
            $(t).select();
        }
        if($("#subtotal").length) {
            $("#subtotal").text(formatter.format(window.sumaTotal));
            $("#bonificacion").text(formatter.format(window.sumaTotal * window.data.descuento * (-1)));
            $("#total").text(formatter.format(window.sumaTotal + (window.sumaTotal * window.data.descuento * (-1))));
        }
    }
    pedir = function(t) {
        alertify.confirm("ATENCIÓN","Está por procesar el pedido. ¿Confirma acción?",
            function(){},
            function() {}
        ).set('labels', {ok:'Si', cancel:'No'});
    };
</script>
@endpush