@push("styles")
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="{{ asset('css/alertifyjs/alertify.min.css') }}" rel="stylesheet">
@endpush
<div class="wrapper-pedido" style="padding: 7em 0;">
    <div class="container">
        <div class="table-responsive">
            <table class="table w-100">
                <thead>
                    
                    @if(!isset($datos["carrito"]))
                    <th style="width:80px;"></th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Unidad de Venta</th>
                    <th>Precio unitario</th>
                    <th>cantidad de productos</th>
                    <th></th>
                    @else
                    <th style="width:80px;"></th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Unidad de Venta</th>
                    <th>Precio unitario</th>
                    <th>cantidad de productos</th>
                    <th>subtotal</th>
                    <th></th>
                    @endif
                </thead>
                <tbody>
                    @foreach($datos["productos"] AS $p)
                    @if(!isset($datos["carrito"]))
                    
                    <tr class="" data-id="{{ $p['id'] }}" data-precio="{{ $p['precio'] }}">
                        <td style="width:80px;">
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
                        <td class="text-center"><button onclick="pedido(this)" type="button" class="btn btn-secondary text-uppercase">pedir</button></td>
                    </tr>
                    @else
                    <tr class="d-none" data-id="{{ $p['id'] }}" data-precio="{{ $p['precio'] }}">
                        <td style="width:80px;">
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
                        <td data-subtotal class="text-right">$ </td>
                        <td class="text-center"><button onclick="eliminar(this)" type="button" class="btn btn-link text-uppercase"><i class="fas fa-times-circle text-mutted"></i></button></td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
            @if(!isset($datos["carrito"]))
            <p><a href="{{ URL::to('carrito') }}" class="text-primary text-uppercase">IR a carrito</a></p>
            @endif
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{ asset('js/alertify.min.js') }}"></script>
<script>
    
    formatter = new Intl.NumberFormat('es-AR', {
        style: 'currency',
        currency: 'ARS',
    });
    window.productos = JSON.parse(localStorage.productos);

    for(let x in window.productos) {
        $(`table *[data-id="${x}"]`).removeClass("d-none");
        $(`table *[data-id="${x}"]`).find("*[data-cantidad] input").val(window.productos[x].cantidad).trigger("change");
        
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
    }
    eliminar = function(t) {
        
        alertify.confirm("ATENCIÓN","¿Eliminar registro?",{
            $(t).remove
            },
            function() {
                $(t).removeAttr("disabled");
            }
        ).set('labels', {ok:'Confirmar', cancel:'Cancelar'});
    }
    function cambio(t) {
        let id = parseInt($(t).closest("tr").data("id"));
        let precio = parseFloat($(t).closest("tr").data("precio"));
        console.log(id)
        let cantidad = parseInt($(t).val());
        $(t).closest("tr").find("*[data-subtotal]").text(formatter.format(precio * cantidad));
    }
</script>
@endpush