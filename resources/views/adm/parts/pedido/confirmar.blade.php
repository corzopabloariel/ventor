
<h3 class="title">{{$title}}</h3>

<section class="my-3">
    <div class="container-fluid">
        <form id="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="card mb-2">
                <div class="card-body" id="ped"></div>
            </div>
            <div class="card mb-2" id="wrapper-tabla">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0 table-striped table-hover" id="tabla"></table>
                    </div>
                </div>
            </div>
            <div class="row justify-content-end mt-4 custom">
                <div class="col-12 col-md-6 col-lg-7">
                    <h5 class="text-uppercase">Observaciones</h5>
                    <textarea maxlength="80" name="observaciones" id="observaciones" placeholder="Observaciones" class="form-control"></textarea>
                </div>
                <div class="col-12 col-md-6 col-lg-5 d-flex flex-column justify-content-between">
                    <h5 class="title border-bottom text-uppercase">Los precios no incluyen IVA</h5>
                    
                    <h4 class="title mt-2 pb-2 border-bottom" style="border-color: #2D3E75 !important;">Total a pagar<big class="float-right" id="total">$ 0,00</big></h4>

                    <a href="{{ URL::to('adm/pedido/create') }}" class="btn btn-block btn-outline-primary mt-3 text-uppercase mr-2">agregar al pedido    </a>

                    <button type="button" disabled="true" id="btnPago" onclick="confirmarOp(this)" class="btn mt-3 btn-block btn-primary text-white text-uppercase">confirmar</button>

                    <button type="button" onclick="cancelar(this)" class="btn mt-3 btn-block btn-danger text-uppercase">cancelar</button>
                </div>
            </div>
        </form>
    </div>
</section>
@push('scripts_distribuidor')
<script src="{{ asset('js/bootstrap-input-spinner.js') }}"></script>
<script>
    const src = "{{ asset('images/general/no-img.png') }}";
    const config = {
        decrementButton: '<i class="fas fa-minus"></i>',
        incrementButton: '<i class="fas fa-plus"></i>',
        buttonsClass: "btn-light btn-sm rounded-0",
        buttonsWidth: "1.5rem",
    };
    window.pyrus = new Pyrus("pedidoProducto", null, src);
    window.clientesUsuarios = @json($clientesUsuarios);
    window.transporte = @json($transporte);
    window.pedido = new Pyrus("pedidos", {cliente_id:{DATA:window.clientesUsuarios,TIPO:"OP"},transporte_id:{DATA:window.transporte,TIPO:"OP"}}, src);
    edit = function(id) {
        let promise = new Promise(function (resolve, reject) {
            let url = `{{ url('adm/productos/show/${id}') }}`;
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
    };
    formatter = new Intl.NumberFormat('es-AR', {
        style: 'currency',
        currency: 'ARS',
    });
    buscarTransporte = function(t) {
        let idCliente = $(t).val();
        if(idCliente != "") {
            let promise = new Promise(function (resolve, reject) {
                let url = `{{ url('adm/clientes/transporte/${idCliente}') }}`;
                var xmlHttp = new XMLHttpRequest();
                xmlHttp.open( "GET", url, true );
                xmlHttp.onload = function() {
                    resolve(xmlHttp.response);
                }
                xmlHttp.send( null );
            });

            promiseFunction = () => {
                promise
                    .then(function(data) {
                        $("#transporte_id").val(data).trigger("change");
                    })
            };
            promiseFunction();
        } else $("#transporte_id").val("").trigger("change");
    };
    cancelar = function(t) {
        alertify.confirm("ATENCIÓN","¿Seguro de cancelar el pedido?",
            function(){
                if(localStorage.idCliente !== undefined) {
                    localStorage.removeItem("idCliente");
                    localStorage.removeItem("idPedido");
                    localStorage.removeItem("observaciones");
                }
                localStorage.removeItem("carrito");
                localStorage.removeItem("pedido");

                let url = `{{ route('pedido.index') }}`;
                window.location = url;
            },
            function(){
            }
        ).set('labels', {ok:'Confirmar', cancel:'Cancelar'});
    };
    procesar = function(t) {
        let formElement = document.getElementById("form");
        let request = new XMLHttpRequest();
        let formData = new FormData(formElement);
        let url = `{{ url('adm/pedido/store') }}`;

        request.responseType = 'json';
        formData.append("pedido", localStorage.pedido);
        if(localStorage.idCliente !== undefined) {
            formData.append("idCliente", localStorage.idCliente);
            formData.append("idPedido", localStorage.idPedido);
            localStorage.removeItem("idCliente");
            localStorage.removeItem("idPedido");
        }
        
        request.open("POST", url);
        request.onload = function() {
            localStorage.removeItem("carrito");
            localStorage.removeItem("pedido");
            data = request.response;
            let url = `{{ url('/export') }}`;
            window.location = url;
        }
        request.send(formData);
    }
    confirmarOp = function(t) {
        alertify.confirm("ATENCIÓN","¿Seguro de procesar el pedido?",
            function(){
                let url = `{{ url('/adm/confirmar/finalizar') }}`;
                let cliente = $("#cliente_id").val();
                let transporte = $("#transporte_id").val();
                if(cliente == "" || transporte == "") {
                    alertify.notify('Complete cliente y transporte', 'warning');
                    return false;
                }
                localStorage.setItem("pedido",JSON.stringify(window.sumTotal));
                procesar(t);
            },
            function(){
            }
        ).set('labels', {ok:'Confirmar', cancel:'Cancelar'});
    };
    
    /** ------------------------------------- */
    addRow = function(data) {
        console.log(data)

        if($("#btnPago").is(":disabled"))
            $("#btnPago").removeAttr("disabled");
        //"{{ asset('/') }}"
        let ARR = [
            /* 0 */data.stmpdh_art,
            /* 1 */data.stmpdh_tex,
            /* 2 */data.codigo_ima,
            /* 3 */data.precio,//categoria
            /* 4 */data.familia_id,
            /* 5 */data.modelo_id
        ];

        if(window.sumTotal === undefined) {
            window.sumTotal = {};
            window.sumTotal["TOTAL"] = 0;
        }
        if(window.sumTotal[data.id] === undefined) {
            window.sumTotal[data.id] = {};
            window.sumTotal[data.id]["PRECIO"] = data.precioSin;
            window.sumTotal[data.id]["PEDIDO"] = parseInt(window.session[data.id]);
        }
        window.sumTotal.TOTAL += parseFloat(window.sumTotal[data.id]["PRECIO"] * window.sumTotal[data.id]["PEDIDO"]);
        $("#subtotal").text(`${formatter.format(window.sumTotal.TOTAL * .09)}`);

        total = window.sumTotal.TOTAL;
        $("#total").text(`${formatter.format(total)}`);

        tr = `<tr data-id="${data.id}">`;
        ARR.forEach(function(e, index) {
            if(index == 2) {
                date = new Date();
                image = `IMAGEN/${e[0]}/${e}.jpg`;
                img = `{{ asset('${image}') }}?t=${date.getTime()}`;
                
                td = `<img class="w-100" src="${img}" onerror="this.src='${src}'"/>`;
                tr += `<td>${td}</td>`;
            } else if(index == 3) {
                tr += `<td class="text-right">${e}</td>`;
            } else
                tr += `<td style="width:100px">${e}</td>`;
        });
        
        tr += `<td class="text-center" style="width: 110px;min-width: 110px">`;
            tr += `<input onchange="recalcular(this)" type="number" value="${window.session[data.id]}" class="form-control text-center cantidad" name="cantidad[]" min="${data.cantminvta}" step="${data.cantminvta}">`;
            //tr += `<button type="button" onclick="pedir(this)" class="btn btn-warning text-uppercase btn-block mt-1 rounded-0 btn-sm">actualizar</button>`
            //tr += `<button onclick="edit(this,${data.id})" class="btn rounded-0 btn-warning"><i class="fas fa-pencil-alt"></i></button>`;
            //tr += `<button onclick="erase(this,${data.id})" class="btn rounded-0 btn-danger"><i class="fas fa-trash-alt"></i></button>`;
        tr += `</td>`;
        tr += `<td class="text-center"><i onclick="del(this)" style="cursor: pointer" class="far fa-times-circle"></i></td>`;
        tr += `</tr>`;
        
        $("table").find("tbody").append(tr);
        $("table").find("tbody").find("tr:last-child() .cantidad").inputSpinner(config);
        //$("table").find("tbody").find(".cantidad").spinner();
    };
    del = function(t) {
        id = $(t).closest("tr").data("id");
        alertify.confirm("ATENCIÓN","¿Seguro de quitar el producto del carrito?",
            function(){
                $(t).closest("tr").remove();
                
                window.sumTotal.TOTAL -= parseFloat(window.sumTotal[id].PRECIO) * window.session[id];
                delete window.session[id];
                localStorage.carrito = JSON.stringify(window.session);
                delete window.sumTotal[id];
                    
                total = window.sumTotal.TOTAL;
                $("#total").text(`${formatter.format(window.sumTotal.TOTAL)}`);

                
                if(window.sumTotal.TOTAL == 0)
                    $("#btnPago").attr("disabled",true);
                
            },
            function(){
            }
        ).set('labels', {ok:'Confirmar', cancel:'Cancelar'});
    };
    recalcular = function(t) {
        cantidad = $(t).val();
        id = $(t).closest("tr").data("id");
        
        window.session[id] = cantidad;
        localStorage.carrito = JSON.stringify(window.session);
        console.log(cantidad)
        window.sumTotal.TOTAL -= parseFloat(window.sumTotal[id].PRECIO) * window.sumTotal[id].PEDIDO;
        window.sumTotal[id].PEDIDO = cantidad;
        window.sumTotal.TOTAL += parseFloat(window.sumTotal[id].PRECIO * cantidad);
        console.log(window.sumTotal.TOTAL)
        $("#total").text(`${formatter.format(window.sumTotal.TOTAL)}`);
    };
    /** ------------------------------------- */
    init = function() {
        console.log("CONSTRUYENDO FORMULARIO Y TABLA");
        /** */
        $("#ped").html(window.pedido.formulario());
        $("#cliente_id").select2({
            tags: "true",
            allowClear: true,
            placeholder: "Seleccione: CLIENTE",
            width: "resolve"
        });
        $("#transporte_id").select2({
            tags: "true",
            allowClear: true,
            placeholder: "Seleccione: TRANSPORTE",
            width: "resolve"
        });

        let columnas = window.pyrus.columnas();
        let table = $("#tabla");
        columnas.forEach(function(e) {
            if(!table.find("thead").length) 
                table.append('<thead class="thead-dark"></thead><tbody></tbody>');
            table.find("thead").append(`<th class="${e.CLASS}" style="width:${e.WIDTH};min-width:${e.WIDTH}">${e.NAME}</th>`);
        });
        table.find("thead").append(`<th class="text-uppercase text-center" style="width:150px"></th>`);
        table.find("thead").append(`<th class="text-uppercase text-center" style="width:150px"></th>`);

        if(localStorage.carrito !== undefined) {
            window.session = JSON.parse(localStorage.carrito);
            for(let x in window.session) {
                edit(x);
            }
        }

        if(localStorage.idCliente !== undefined) {
            $("#cliente_id").val(localStorage.idCliente).trigger("change");
            $("#cliente_id").attr("disabled",true);

            $("#observaciones").val(localStorage.observaciones == "null" ? "" : localStorage.observaciones).trigger("change");
        }
    }
    /** */
    init();
</script>
@endpush