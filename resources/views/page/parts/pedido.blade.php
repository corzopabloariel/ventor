@push("styles")
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="{{ asset('css/alertifyjs/alertify.min.css') }}" rel="stylesheet">
@endpush
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="zoom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img class="w-100 d-block"/>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modalPedir" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" onclick="pedido(this)" class="btn btn-primary">Pedir</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="descargarPDF">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Regresar al listado de PRODUCTOS</button>
                <button onclick="generarPDF()" type="button" class="btn btn-primary">Descargar <i class="fas fa-file-pdf"></i></button>
            </div>
        </div>
    </div>
</div>
<div class="wrapper-pedido py-5">
    <div class="container-fluid">
        @if(isset($datos["carrito"]))
            <h2 class="title mb-3 text-uppercase">carrito (<span id="cantProductos">0</span>)</h2>
        @endif
        @if(isset($datos["carrito"]))
        <div class="table-responsive">
            <table class="table w-100" id="tabla">
                <thead>
                    <th style="width:100px;"></th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th class="text-center">U. Venta</th>
                    <th class="text-right">P. unitario</th>
                    <th class="text-center">c. productos</th>
                    <th class="text-right">subtotal</th>
                    <th class="text-center">eliminar</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        @else
        <div class="row">
            <div class="col-12 col-md-3">
                <button class="btn text-white text-uppercase d-block d-sm-none rounded-0 mb-2" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" style="background: #0099D6">
                    categorias<i class="fas fa-sort-amount-down ml-2"></i>
                </button>
                <div class="sidebar collapse dont-collapse-sm" id="collapseExample">
                    <div class="sidebar accordion" id="accordionExample">
                        @foreach($datos["menu"] AS $dato)
                        <div class="accordion md-accordion border-0" id="accordionEx" role="tablist" aria-multiselectable="true">
                            <div class="card border-0">
                                <div class="card-header bg-white p-0 border-bottom" role="tab" id="Hproductos{{$dato['id']}}">
                                    <h5 style="color:{{$dato['color']}}; cursor: pointer" class="mb-0 parte py-3" data-parent="#accordionEx" data-toggle="collapse" data-target="#productos{{$dato['id']}}" aria-expanded="@if(isset($dato['active'])) true @else false @endif" aria-controls="productos{{$dato['id']}}">
                                        <a class="" href="{{ URL::to('pedido/parte/' . $dato['id']) }}">
                                            {{$dato["nombre"]}}
                                        </a>
                                        <i class="fas fa-angle-down rotate-icon float-right"></i>
                                    </h5>
                                </div>
                                <div id="productos{{$dato['id']}}" class="collapse @if(isset($dato['active'])) show @endif" role="tabpanel" aria-labelledby="Hproductos{{$dato['id']}}" data-parent="#accordionEx">
                                    <div class="card-body p-0">
                                    @if(count($dato["hijos"]) > 0)
                                        <ul data-nivel="{{$dato['tipo']}}" class="list-group list-group-flush subPartes">
                                        @foreach ($dato["hijos"] AS ${"dato_". $dato["id"]})
                                            @include('page.parts.productos._menuItem', ["dato" => ${"dato_". $dato["id"]},"id" => $dato["id"],"url" => "pedido"])
                                        @endforeach
                                        </ul>
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-9">
                <div class="row justify-content-center mb-3">
                    <div class="col-12 col-md-6">
                        <form action="" method="post" class="buscador position-relative">
                            @csrf
                            <div class="position-relative">
                                <button type="submit" class="btn btn-link position-absolute"><i class="fas fa-search"></i></button>
                                <input type="text" name="buscar" value="@if(!empty($datos['buscar'])) {{ $datos['buscar'] }} @endif" class="form-control" placeholder="Buscar código o nombre">
                            </div>
                            <div class="d-flex align-items-baseline mt-3">
                                <select name="para" id="para" class="form-control">
                                    <option></option>
                                    @foreach($datos["para"] AS $i => $v)
                                        @if(isset($datos["paraID"]))
                                        <option @if($datos["paraID"] == $i) selected @endif value="{{$i}}">{{$v}}</option>
                                        @else
                                        <option value="{{$i}}">{{$v}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="submit" class="btn text-white btn-sm btn-secondary text-uppercase ml-2">filtrar</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="d-flex align-items-end justify-content-end" style="height: 39.5px;">
                            <div class="form-check">
                                <input class="form-check-input" onchange="changeMarkUp(this);" type="radio" name="markup" id="costo" value="costo" checked>
                                <label class="form-check-label" for="costo">
                                    COSTO
                                </label>
                            </div>
                            <div class="form-check ml-3">
                                <input class="form-check-input" onchange="changeMarkUp(this);" type="radio" name="markup" id="venta" value="venta">
                                <label class="form-check-label" for="venta">
                                    VENTA
                                </label>
                            </div>
                        </div>
                        @if(auth()->guard('client')->user()["is_vendedor"] > 0)
                        <div class="mt-3">
                            <select onchange="selectClient(this);" name="clientesSELECT" id="clientesSELECT" class="form-control">
                                <option value=""></option>
                                @foreach($datos["clientes"] AS $i => $c)
                                <option value="{{$i}}">{{$c}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table w-100" id="tabla">
                        <thead>
                            <th style="width:100px;"></th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th style="width: 100px;" class="text-center">U. Venta</th>
                            <th style="width: 100px;" class="text-center">Stock</th>
                            <th style="width: 100px;" class="text-right">P. unitario</th>
                            {{--<th>c. productos</th>--}}
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach($datos["productos"] AS $p)
                            
                            <tr class="" data-id="{{ $p['id'] }}" data-precio="{{ $p['precio'] }}" data-min="{{ $p['cantminvta'] }}" data-step="{{ $p['cantminvta'] }}">
                                <td style="width:100px;">
                                    @php
                                    $image = asset("IMAGEN/{$p["codigo_ima"][0]}/{$p["codigo_ima"]}.jpg");
                                    @endphp
                                    <div class="zoom" onclick="zoom(this)">
                                        <img class="border w-100" src="{{ $image }}" onerror="this.src='{{ asset('images/general/no-img.png') }}'"/>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0" style="font-weight:bold">{{ $p["stmpdh_art"] }}</p>
                                    <p class="mb-0" style="color: #212529">{!! $p["stmpdh_tex"] !!}</p>
                                </td>
                                <td>{!! $p->parte_id() !!}</td>
                                <td class="text-center">{{ $p["cantminvta"] }}</td>
                                <td class="text-center">
                                    <button class="btn btn-secondary" onclick="verificarStock(this,'{{$p['use']}}',{{ empty($p['stock_mini']) ? 0 : $p['stock_mini'] }});" type="button">
                                        <i class="fas fa-traffic-light"></i>
                                    </button>
                                </td>
                                <td class="text-right" data-precio="{{ $p['precio'] }}">{{ "$ " . $p->getPrecio() }}</td>
                                <td data-btn class="text-center">
                                    <button onclick="addPedido(this)" type="button" class="btn btn-secondary text-uppercase addpedido"><i class="fas fa-cart-plus"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2 d-flex justify-content-center">
                    <div class="overflow-auto">
                    @if(!empty($datos['buscar']))
                        {{ $datos["productos"]->appends( [ "buscar" => $datos["buscar"] ] )->links() }}
                    @else
                        {{ $datos["productos"]->links() }}
                    @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(isset($datos["carrito"]))
        <div class="row mt-3">
            <div class="col-12 col-md-7 obs">
                <p>Transporte</p>
                <select name="transporteUSER" class="form-control" id="transporteUSER">
                    <option value=""></option>
                    @foreach($datos["transportes"] AS $i => $t)
                    <option value="{{$i}}" @if($i == $datos["cliente"]["transporte_id"]) selected @endif>{{$t}}</option>
                    @endforeach
                </select>

                <p class="mt-3">Observaciones</p>
                <textarea name="observaciones" id="observaciones" rows="3" class="form-control" placeholder="Observaciones"></textarea>
            </div>
            <div class="col-12 col-md-5 valor">
                {{--<p class="mb-2 d-flex w-100 justify-content-between">Subtotal (no incluye IVA)<span id="subtotal">$ 0</span></p>
                @php
                $descuento = auth()->guard('client')->user()["descuento"];
                $descuento *= 100;
                @endphp
                <p class="mb-4 d-flex w-100 justify-content-between"><span>Bonificacion (<span id="bonificacionCliente">{{$descuento}}%</span>)</span> <span id="bonificacion">$ 0</span></p>--}}
                <p class="total border-bottom border-dark mb-1 d-flex w-100 align-items-center justify-content-between">Total <span id="total">$ 0</span></p>
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
        @endif
    </div>
</div>
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{ asset('js/alertify.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-input-spinner.js') }}"></script>
<script>
    const imgDefault = "{{ asset('images/general/no-img.png') }}";
    if(localStorage.utilidadON !== undefined) {
        $('input:radio[name="markup"][value="venta"]').prop('checked',true)
        $("input:radio[name='markup'][value='venta']").trigger("change");
    }
    $(document).ready(function() {
        if($("#transporteUSER").length) {
            if(localStorage.transporteID !== undefined)
                $("#transporteUSER").val(localStorage.transporteID).trigger("change");
        }
        if(localStorage.clienteNAME)//background-color: #0099D8;
            $("h2.title").append(`<div class="mt-2" style="font-size: 17px; font-weight: 400"><strong class="mr-2">Cliente:</strong>${localStorage.clienteNAME}</small></div>`);
        if($("#clientesSELECT").length) {
            if(localStorage.clienteID !== undefined)
                $("#clientesSELECT").val(localStorage.clienteID).trigger("change");
            $("#clientesSELECT").select2({
                theme: "bootstrap",
                placeholder: "Clientes",
                allowClear: true,
                width: "resolve"
            });    
        }
        if($("#transporteUSER").length) {
            $("#transporteUSER").select2({
                theme: "bootstrap",
                placeholder: "Seleccione Transporte",
                width: "resolve"
            });
        }
        $("#para").select2({
            theme: "bootstrap",
            placeholder: "Marca",
            width: "resolve"
        });
        if($("input[type='number']").length) {
            let config = {
                decrementButton: '<i class="fas fa-minus"></i>',
                incrementButton: '<i class="fas fa-plus"></i>',
                buttonsClass: "btn-outline-secondary btn-sm",
                buttonsWidth: "1.5rem",
            }
            $( "input[type='number']" ).inputSpinner(config);
        }

        $("#descargarPDF").on('hidden.bs.modal', function (e) {
            url = `{{ url('pedido') }}`;
            alertify.warning("Espere. Regresando al listado de PRODUCTOS");
            setTimeout(() => {
                window.location = url;
            }, 3000);
        });
    });
    formatter = new Intl.NumberFormat('es-AR', {
        style: 'currency',
        currency: 'ARS',
    });

    if(localStorage.productos !== undefined) {
        window.productos = JSON.parse(localStorage.productos);
        window.normal = 1;
        @if(isset($datos["carrito"]))
        for(let id in window.productos) {
            let promise = new Promise(function (resolve, reject) {
                let url = `{{ url('productoSHOW/${id}') }}`;
                var xmlHttp = new XMLHttpRequest();
                xmlHttp.responseType = 'json';
                xmlHttp.open( "GET", url, true );
                xmlHttp.onload = function() {
                    resolve(xmlHttp.response);
                }
                xmlHttp.send( null );
            });

            promiseFunction = () => {
                promise
                    .then(function(data) {
                        addRow(data);
                    })
            };
            promiseFunction();
        }
        @endif
        for(let x in window.productos) {
            $(`table *[data-id="${x}"]`).removeClass("d-none");
            $(`table *[data-id="${x}"]`).find("*[data-cantidad] input").val(window.productos[x].cantidad).trigger("change");
            $(`table *[data-id="${x}"]`).find("*[data-btn] button").removeClass("btn-secondary").addClass("btn-warning")
        }
        delete window.normal;
        if(Object.keys(window.productos).length > 0) {
            if(!$("[data-carrito] > a > span").length) 
                $("[data-carrito] > a").append(`<span class="ml-1">(${Object.keys(window.productos).length})</span>`);
            if($("#cantProductos").length)
                $("#cantProductos").text(Object.keys(window.productos).length);
        }
    }

    selectClient = function(t) {
        let val = $(t).val();
        if(val == "") {
            if(localStorage.clienteID !== undefined) {
                localStorage.removeItem("clienteID");
                localStorage.removeItem("clienteNAME");
                
                if(localStorage.transporteID !== undefined)
                    localStorage.removeItem("transporteID");
            }
        } else {
            localStorage.setItem("clienteID",val);
            localStorage.setItem("clienteNAME",$(t).find(`option[value="${val}"]`).text());
            let promise = new Promise(function (resolve, reject) {
                let url = `{{ url('cliente/transporteCliente/${val}') }}`;
                var xmlHttp = new XMLHttpRequest();
                //xmlHttp.responseType = 'json';
                xmlHttp.open( "GET", url, true );
                xmlHttp.onload = function() {
                    resolve(xmlHttp.response);
                }
                xmlHttp.send( null );
            });

            promiseFunction = () => {
                promise
                    .then(function(data) {
                        localStorage.setItem("transporteID",data);
                    })
            };
            promiseFunction();
        }
    }
    /** ------------------------------------- */
    zoom = function(t) {
        img = $(t).find("img").attr("src");
        $("#zoom").find(".modal-title").text($(t).closest("td").next().find("p:last-child").text());
        $("#zoom").find("img").attr("src",img);
        $("#zoom").modal("show");
    }
    addRow = function(data) {
        
        $("#tabla tbody").append(`<tr data-id="${data.id}" data-precio="${data.precio}">` +
            `<td style="">` +
                `<div class="zoom" onclick="zoom(this)">` + 
                `<img class="border w-100" src="${data.image}" onerror="this.src='${imgDefault}'"/>` +
                `</div>` +
            `</td>` +
            `<td><p class="mb-0" style="font-weight:bold">${data.stmpdh_art}</p><p class="mb-0" style="color:#212529">${data.stmpdh_tex}</p></td>` +
            `<td>${data.parte_id}</td>` +
            `<td class="text-center">${data.cantminvta}</td>` +
            `<td class="text-right">$ ${data.precioF}</td>` +
            `<td data-cantidad style="width: 140px;"><input onchange="cambio(this)" type="number" class="form-control text-right" name="cantidad[]" min="${data.cantminvta}" step="${data.cantminvta}"></td>` +
            `<td class="text-right" data-subtotal class="text-right">$ </td>` +
            `<td class="text-center"><button onclick="eliminar(this)" type="button" class="btn btn-link text-uppercase" style="color:#9B9B9B"><i class="far fa-times-circle"></i></button></td>` +
        `</tr>`);
        $("#tabla tbody").find("tr:last-child input[type='number']").val(window.productos[data.id]["cantidad"]).trigger("change");
        if($("#tabla tbody").find("tr:last-child input[type='number']").length) {
            $("#tabla tbody").find("tr:last-child input[type='number']").inputSpinner({
                decrementButton: '<i class="fas fa-minus"></i>',
                incrementButton: '<i class="fas fa-plus"></i>',
                buttonsClass: "btn-outline-secondary btn-sm",
                buttonsWidth: "1.5rem",
            });
        }
    };
    addPedido = function(t) {
        let modal = $("#modalPedir");
        let id = $(t).closest("tr").data("id");
        let precio = $(t).closest("tr").data("precio");
        let min = $(t).closest("tr").data("min");
        let step = $(t).closest("tr").data("step");
        let titulo = $(t).closest("tr").find("td:nth-child(2) p:last-child").text();
        let html = "";
        html += `<table class="table mb-0">`;
            html += `<thead>`;
                html += `<th style="width: 100px; color:#0099D8; vertical-align:middle" class="text-right bg-light">PRECIO UNITARIO</th>`;
                html += `<th class="bg-light" style="color:#0099D8;vertical-align:middle">CANTIDAD DE PRODUCTOS</th>`;
                html += `<th style="width: 100px; vertical-align:middle; color:#0099D8" class="text-right bg-light">SUBTOTAL</th>`;
            html += `</thead>`;
            html += `<tbody>`;
                html += `<tr data-id="${id}" data-precio="${precio}">`;
                    html += `<td style="vertical-align:middle" class="text-right">${formatter.format(precio)}</td>`;
                    html += `<td data-cantidad style="width:150px"><input pattern="[0-9]+" onchange="cambio(this)" type="number" class="form-control text-center" name="" min="${min}" step="${step}" id=""></td>`;
                    html += `<td data-subtotal style="vertical-align:middle" class="text-right">$ -,--</td>`;
                html += `</tr>`;
            html += `</tbody>`;
        html += `</table>`;
        modal.find(".modal-body").html(html);
        modal.find(".modal-title").text(titulo);
        if(window.productos !== undefined) {
            if(window.productos[id] !== undefined) 
                modal.find("input[type='number']").val(window.productos[id].cantidad).trigger("change");
        }

        modal.find("input[type='number']").inputSpinner({
            decrementButton: '<i class="fas fa-minus"></i>',
            incrementButton: '<i class="fas fa-plus"></i>',
            buttonsClass: "btn-outline-secondary btn-sm",
            buttonsWidth: "1.5rem",
        });
        modal.modal("show");
    }
    pedido = function(t) {
        let modalPedir = $("#modalPedir table tbody tr");
        let id = modalPedir.data("id");
        let precio = modalPedir.data("precio");
        let cantidad = modalPedir.find("*[data-cantidad] input").val();
        if(cantidad == "") {
            alertify.error("Complete la cantidad");
            return false;
        }
        if(parseInt(cantidad) == 0) {
            alertify.error("La cantidad debe ser mayor a 0");
            return false;
        }
        if(window.productos === undefined)
            window.productos = {};
        if(window.productos[id] === undefined)
            window.productos[id] = {cantidad: 0,precio:precio};
        window.productos[id].cantidad = cantidad;

        localStorage.setItem("productos",JSON.stringify(window.productos));
        alertify.success(`${window.productos[id].cantidad} u. seleccionadas`);
                console.log(window.productos)
        if(Object.keys(window.productos).length > 0) {
            if(!$("nav [data-carrito] > a > span").length) 
                $("nav [data-carrito] > a").append(`<span class="ml-1">(${Object.keys(window.productos).length})</span>`);
            else
                $("nav [data-carrito] > a > span").text(`(${Object.keys(window.productos).length})`);
        }
        $("#modalPedir").modal("hide");
        $(`table *[data-id="${id}"]`).find("*[data-btn] button").removeClass("btn-secondary").addClass("btn-warning")
    }
    generarPDF = function() {
        let url = `{{ url('pdf') }}`;
        var xmlHttp = new XMLHttpRequest();
        let formData = new FormData();
        formData.append("_token","{{ csrf_token() }}");
        //xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xmlHttp.responseType = 'blob';
        xmlHttp.open( "POST", url, true );
        xmlHttp.onload = function() {
            if(xmlHttp.status === 200) {
                var disposition = xmlHttp.getResponseHeader('content-disposition');
                var matches = /"([^"]*)"/.exec(disposition);
                var filename = (matches != null && matches[1] ? matches[1] : 'file.pdf');

                // The actual download
                var blob = new Blob([xmlHttp.response], { type: 'application/pdf' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;

                document.body.appendChild(link);

                link.click();

                document.body.removeChild(link);

                url = `{{ url('pedido') }}`;
                window.location = url;
            }
        }
        xmlHttp.send( formData );
    }
    eliminar = function(t) {
        let id = $(t).closest("tr").data("id");
        
        alertify.confirm("ATENCIÓN","¿Eliminar registro?",
            function() {
                let precio = parseFloat($(t).closest("tr").data("precio"));
                let cantidad = parseInt($(t).closest("tr").find("td[data-cantidad] input").val());
                window.sumaTotal.TOTAL -= precio * cantidad;
                
                $("#total").text(formatter.format(window.sumaTotal.TOTAL));
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
    verificarStock = function(t, use, stock = null) {
        $(t).attr("disabled",true);
        nombre = $(t).closest("tr").find("td:nth-child(2) p:last-child").text();
        let promise = new Promise(function (resolve, reject) {
            let url = `{{ url('/soap/${use}') }}`;
            var xmlHttp = new XMLHttpRequest();
            //xmlHttp.responseType = 'json';
            xmlHttp.open( "GET", url, true );
            xmlHttp.onload = function() {
                /**
                    * -3 //ERR grande
                    * -2 //ERR de conexión
                    * -1 //ERR
                    */
                resolve(xmlHttp.response);
            }
            xmlHttp.send( null );
        });

        promiseFunction = () => {
            promise
                .then(function(data) {
                    stockData = parseInt(data);
                    console.log(stockData);
                    $(t).removeAttr("disabled");
                    if(stockData < 0) 
                        alertify.error("Ocurrió un error, intente más tarde");
                    else {
                        if(stock !== null) {
                            if(stockData > parseInt(stock)) {
                                $(t).removeClass("btn-secondary").addClass("btn-success");
                                alertify.success("Stock disponible");
                            } else if(stockData <= parseInt(stock) && stockData > 0) {
                                $(t).removeClass("btn-secondary").addClass("btn-warning");
                                alertify.warning("Stock inferior o igual a cantidad crítica");
                            } else {
                                $(t).removeClass("btn-secondary").addClass("btn-danger");
                                alertify.error("Sin Stock");
                            }
                        }
                    }
                })
        };
        alertify.notify(`Verificando STOCK de ${nombre}`, '', 5, function(){ });
        promiseFunction();
    }
    function cambio(t) {
        if($("#total").length) {
            id = parseInt($(t).closest("tr").data("id"));
            if($(t).closest("tr").data("precio") == "") {
                $(t).closest("tr").find("*[data-subtotal]").text(formatter.format(0));
                return false;
            }
            precio = parseFloat($(t).closest("tr").data("precio"));
            cantidad = parseInt($(t).val());

            step = parseInt($(t).attr("step"));
            if(cantidad % step === 0) {
                if(window.sumaTotal === undefined) {
                    window.sumaTotal = {};
                    window.sumaTotal.TOTAL = 0.0;
                }
                if(window.sumaTotal[id] !== undefined)
                    window.sumaTotal.TOTAL -= precio * window.sumaTotal[id];
                if(window.sumaTotal[id] === undefined)
                    window.sumaTotal[id] = 0;    
                window.sumaTotal[id] = cantidad;
                /*------ RESTO PRIMERO */
                if(window.normal === undefined)
                
                /*------ SUMO EL NUEVO VALOR */
                window.sumaTotal.TOTAL += precio * cantidad;
                window.productos[id].cantidad = cantidad;
                localStorage.setItem("productos",JSON.stringify(window.productos));

                $(t).closest("tr").find("*[data-subtotal]").text(formatter.format(precio * cantidad));
            } else {
                alertify.notify(`Cantidad no permitida. Solo múltiplos de ${step}`, 'warning');
                $(t).select();
            }
             
            $("#total").text(formatter.format(window.sumaTotal.TOTAL));
        } else {
            id = parseInt($(t).closest("tr").data("id"));
            if($(t).closest("tr").data("precio") == "") {
                $(t).closest("tr").find("*[data-subtotal]").text(formatter.format(0));
                return false;
            }
            precio = parseFloat($(t).closest("tr").data("precio"));
            cantidad = parseInt($(t).val());

            step = parseInt($(t).attr("step"));
            if(cantidad % step === 0) {
                $(t).closest("tr").find("*[data-subtotal]").text(formatter.format(precio * cantidad));
            } else {
                alertify.notify(`Cantidad no permitida. Solo múltiplos de ${step}`, 'warning');
                $(t).select();
            }
        }
    }
    pedir = function(t) {
        alertify.confirm("ATENCIÓN","Está por procesar el pedido. ¿Confirma acción?",
            function() {
                let promise = new Promise(function (resolve, reject) {
                    let request = new XMLHttpRequest();
                    let url = `{{ url('pedidoCliente') }}`;
                    let formData = new FormData();
                    let data = @json(auth()->guard('client')->user());
                    console.log(data)
                    request.responseType = 'json';
                    formData.append("_token","{{ csrf_token() }}");
                    if(localStorage.clienteID !== undefined)
                        formData.append("idCliente",localStorage.clienteID);
                    
                    formData.append("idUsuario",data.id);
                    formData.append("idVendedor",data.vendedor_id);
                    formData.append("observaciones",$("#observaciones").val());
                    formData.append("transporteID",$("#transporteUSER").val());
                    
                    formData.append("pedido", JSON.stringify(window.productos));
                    var xmlHttp = new XMLHttpRequest();

                    xmlHttp.open( "POST", url );
                    xmlHttp.onload = function() {
                        localStorage.clear();
                        alertify.success(`Pedido realizado`);
                        resolve(xmlHttp.response);
                    }
                    xmlHttp.send( formData );
                });

                promiseFunction = () => {
                    promise
                        .then(function(data) {
                            //MANDAMOS el excel
                            let promise2 = new Promise(function (resolve, reject) {
                                url = `{{ URL::to('export/usr') }}`;
                                var xmlHttp = new XMLHttpRequest();
                                xmlHttp.open( "GET", url, true );
                                
                                xmlHttp.send( null );
                                resolve(xmlHttp.responseText);
                            });

                            promiseFunction2 = () => {
                                promise
                                    .then(function(msg) {
                                        html = "";
                                        html += `<p class="mb-0 text-center">¿Descargar pedido en PDF?</p>`
                                        modal = $("#descargarPDF");
                                        modal.find(".modal-title").text("Pedido finalizado");
                                        modal.find(".modal-body").html(html);
                                        modal.modal({
                                            backdrop: 'static',
                                            keyboard: false
                                        });
                                    })
                            };
                            promiseFunction2();
                        })
                };
                promiseFunction();
            },
            function() {}
        ).set('labels', {ok:'Si', cancel:'No'});
    };
</script>
@endpush