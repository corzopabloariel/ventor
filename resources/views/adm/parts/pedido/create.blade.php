
<h3 class="title">{{$title}}</h3>

<section class="mt-3">
    <div class="container-fluid">
        <div class="d-flex mb-2">
            <form class="position-relative d-inline-block" action="" method="post">
                <input style="width: 350px;" type="text" name="buscar" class="form-control" placeholder="Buscador: Código o Nombre" value="{{ $buscar }}"/>
                @csrf
                <i style="right:10px;top: calc(50% - 7px); z-index: 1;" class="fas fa-search position-absolute"></i>
            </form>
            <button type="button" onclick="location.href='{{ route('pedido.confirmar') }}'" class="btn btn-success ml-2">Pedido <span class="badge badge-light" id="cantidad">0</span></button>
        </div>
        <div class="card" id="wrapper-tabla">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm mb-0 table-striped table-hover" id="tabla"></table>
                </div>
                <div class="mt-2">
                    {{ $productos->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts_distribuidor')
<script src="{{ asset('js/bootstrap-input-spinner.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.11.4/basic/ckeditor.js"></script>
<script src="{{ asset('js/jquery.maskMoney.js') }}"></script>
<script>
    const src = "{{ asset('images/general/no-img.png') }}";
    const config = {
        decrementButton: '<i class="fas fa-minus"></i>',
        incrementButton: '<i class="fas fa-plus"></i>',
        buttonsClass: "btn-light btn-sm rounded-0",
        buttonsWidth: "1.5rem",
    };
    window.pyrus = new Pyrus("pedidoProducto", null, src);
    window.elementos = @json($productos);
    init = function() {
        console.log("CONSTRUYENDO FORMULARIO Y TABLA");
        /** */
        let columnas = window.pyrus.columnas();
        let table = $("#tabla");
        columnas.forEach(function(e) {
            if(!table.find("thead").length) 
                table.append('<thead class="thead-dark"></thead>');
            table.find("thead").append(`<th class="${e.CLASS}" style="width:${e.WIDTH};min-width:${e.WIDTH}">${e.NAME}</th>`);
        });
        table.find("thead").append(`<th class="text-uppercase text-center" style="width:150px">acción</th>`);

        window.elementos.data.forEach(function(data) {
            let tr = "";
            if(!table.find("tbody").length) 
                table.append("<tbody></tbody>");
            columnas.forEach(function(c) {
                td = data[c.COLUMN] === null ? "" : data[c.COLUMN];
                if(window.pyrus.especificacion[c.COLUMN].TIPO == "TP_FILE") {
                    date = new Date();
                    image = `IMAGEN/${td[0]}/${td}.jpg`;
                    img = `{{ asset('${image}') }}?t=${date.getTime()}`;
                    td = `<img class="w-100" src="${img}" onerror="this.src='${src}'"/>`;
                }
                if(window.pyrus.especificacion[c.COLUMN].TIPO == "TP_COLOR") {
                    td = `${td}<div class="mt-1" style="height:10px; background: ${td}"></div>`;
                }
                if(window.pyrus.especificacion[c.COLUMN].TIPO == "TP_ENUM") {
                    if(window.pyrus.especificacion[c.COLUMN].ENUM !== undefined) {
                        if(Object.keys(window.pyrus.especificacion[c.COLUMN].ENUM).length > 0)
                            td = window.pyrus.especificacion[c.COLUMN].ENUM[td];
                    }
                }
                tr += `<td data-${c.COLUMN} class="${c.CLASS}" style="width:${c.WIDTH};min-width:${c.WIDTH}">${td}</td>`;
            });
            tr += `<td class="text-center">`;
                tr += `<input onclick="recalcular(this)" type="number" value="0" class="form-control text-center cantidad" name="cantidad[]" min="${data.cantminvta}" step="${data.cantminvta}">`;
                tr += `<button type="button" onclick="pedir(this)" class="btn btn-warning text-uppercase btn-block mt-1 rounded-0 btn-sm">pedir</button>`
                //tr += `<button onclick="edit(this,${data.id})" class="btn rounded-0 btn-warning"><i class="fas fa-pencil-alt"></i></button>`;
                //tr += `<button onclick="erase(this,${data.id})" class="btn rounded-0 btn-danger"><i class="fas fa-trash-alt"></i></button>`;
            tr += `</td>`;
            table.find("tbody").append(`<tr data-id="${data.id}">${tr}</tr>`);
            $("table").find("tbody").find("tr:last-child() .cantidad").inputSpinner(config);
        });

        if(localStorage.carrito !== undefined) {
            window.session = JSON.parse(localStorage.carrito);
            $("#cantidad").text(Object.keys(window.session).length)
            for(let x in window.session) {
                if($("#tabla").find(`tbody tr[data-id="${x}"]`).length)
                    $("#tabla").find(`tbody tr[data-id="${x}"] .cantidad`).val(window.session[x]);
            }
        }
    }
    /** */
    init();

    pedir = function(t) {
        idProducto = $(t).closest("tr").data("id");
        cantidad = $(t).parent().find("input").val();
        console.log(cantidad)
        
        if(localStorage.carrito === undefined)
            localStorage.setItem("carrito","{}");
        window.session = JSON.parse(localStorage.carrito);
        $("#cantidad").text(Object.keys(window.session).length);

        if(window.session[idProducto] === undefined) {
            window.session[idProducto] = parseInt(cantidad);
            
            localStorage.carrito = JSON.stringify(window.session);
            alertify.success('Producto agregado');
        } else {
            window.session[idProducto] = parseInt(cantidad);
            
            localStorage.carrito = JSON.stringify(window.session);
            alertify.success('Cantidad modificada');
        }
    };
</script>
@endpush