
<h3 class="title">{{$title}}</h3>

<section class="mt-3">
    <div class="container-fluid">
        <div>
            <button id="btnADD" onclick="location.href='{{ route('pedidoCreate') }}'" class="btn btn-primary text-uppercase" type="button">Agregar<i class="fas fa-plus ml-2"></i></button>
        </div>
        <div class="mt-2" style="display: none;" id="wrapper-form">
            <div class="card">
                <div class="card-body">
                    <button onclick="remove(this)" type="button" class="close position-absolute" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                    <form id="form" novalidate class="pt-2" action="{{ url('/adm/familia/store') }}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="container-form"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card mt-2" id="wrapper-tabla">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0 table-hover" id="tabla"></table>
                </div>
                <div class="mt-2">{{ $pedidos->links() }}</div>
            </div>
        </div>
    </div>
</section>
@push('scripts_distribuidor')
<script src="https://cdn.ckeditor.com/4.11.4/basic/ckeditor.js"></script>
<script src="{{ asset('js/jquery.maskMoney.js') }}"></script>
<script>
    $(document).on("ready",function() {
        $(".ckeditor").each(function () {
            CKEDITOR.replace( $(this).attr("name") , {
                height: 75
            });
        });
    });
    const src = "{{ asset('images/general/no-img.png') }}";
    window.clientesUsuarios = @json($clientesUsuarios);
    window.transporte = @json($transporte);
    window.pyrus = new Pyrus("pedidos", {cliente_id:{DATA:window.clientesUsuarios,TIPO:"OP"},transporte_id:{DATA:window.transporte,TIPO:"OP"}}, src);
    window.elementos = @json($pedidos);
    
    /** ------------------------------------- */
    add = function(t, id = 0, data = null) {
        let btn = $(t);
        if(btn.is(":disabled"))
            btn.removeAttr("disabled");
        else
            btn.attr("disabled",true);
        $("#wrapper-form").toggle(800,"swing");

        $("#wrapper-tabla").toggle("fast");

        if(id != 0)
            action = `{{ url('/adm/${window.pyrus.entidad}/update/${id}') }}`;
        else
            action = `{{ url('/adm/${window.pyrus.entidad}/store') }}`;
        if(data !== null) {
            console.log(data)
            for(let x in window.pyrus.especificacion) {
                if(window.pyrus.especificacion[x].EDITOR !== undefined) {
                    if(CKEDITOR.instances[x] !== undefined)
                        CKEDITOR.instances[x].setData(data[x]);
                    continue;
                }
                if(window.pyrus.especificacion[x].TIPO == "TP_CHECK") {
                    if(window.pyrus.especificacion[x].DEFAULT === undefined) {
                        if(parseInt(data[x]) == 1)
                            $(`[name="${x}"]`).prop("checked", true);
                    } else {
                        if(window.pyrus.especificacion[x].DEFAULT.localeCompare(data[x]) == 0)
                            $(`[name="${x}"]`).prop("checked", true);
                    }
                    continue;
                }
                if(window.pyrus.especificacion[x].TIPO == "TP_FILE") {
                    date = new Date();
                    img = `{{ asset('${data[x]}') }}?t=${date.getTime()}`;
                    $(`#src-${x}`).attr("src",img);
                    continue;
                }
                if(x == "familia_id" || x == "categoria_id" || x == "origen_id" || x == "marca_id") {
                    window[`set_${x}`] = data[x];
                    continue;
                }
                $(`[name="${x}"]`).val(data[x]).trigger("change");
            }
            $("#cantidad").val(data.cantidad)
            $("#familia_id").val(window.set_familia_id).trigger("change");
            $("#origen_id").val(window.set_origen_id).trigger("change");
            $("#marca_id").val(window.set_marca_id).trigger("change");
        } else {
            if($("#tabla tbody").length)
                $("#orden").val($("#tabla tbody").find("tr:last-child() *[data-orden]").text());
            else
                $("#orden").val("AA");
        }
        elmnt = document.getElementById("form");
        elmnt.scrollIntoView();
        $("#form").attr("action",action);
    };
    init = function() {
        console.log("CONSTRUYENDO FORMULARIO Y TABLA");
        /** */
        html = "";
        html += window.pyrus.formulario();
        html += `<fieldset class="mt-3">`;
            html += `<legend class="border-0 p-0"><button class="rounded-0 btn btn-dark text-uppercase">producto<i class="fas fa-plus ml-2"></i></button></legend>`;
        html += `</fieldset>`; 
        $("#form .container-form").html(html);
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
                table.append('<thead class="thead-dark"></thead>');
            table.find("thead").append(`<th class="${e.CLASS}" style="width:${e.WIDTH};min-width:${e.WIDTH}">${e.NAME}</th>`);
        });
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
            //tr += `<td class="text-center">`;
                //tr += `<button onclick="edit(this,${data.id})" class="btn rounded-0 btn-warning"><i class="fas fa-pencil-alt"></i></button>`;
                //tr += `<button onclick="erase(this,${data.id})" class="btn rounded-0 btn-danger"><i class="fas fa-trash-alt"></i></button>`;
            //tr += `</td>`;
            table.find("tbody").append(`<tr data-id="${data.id}">${tr}</tr>`);
        });
    };
    /** */
    init();
</script>
@endpush