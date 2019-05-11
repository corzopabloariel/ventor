@push("styles")
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush
<h3 class="title">{{$title}}</h3>

<section class="mt-3">
    <div class="container-fluid">
        <div>
            <button id="btnADD" onclick="add(this)" class="btn btn-primary text-uppercase" type="button">Agregar<i class="fas fa-plus ml-2"></i></button>
        </div>
        <div style="display: none;" id="wrapper-form" class="mt-2">
            <div class="card">
                <div class="card-body">
                    <button onclick="remove(this)" type="button" class="close position-absolute" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                    <form id="form" novalidate class="pt-2" action="{{ url('/adm/familia/store') }}" onsubmit="event.preventDefault(); submitProducto(this);" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="container-form"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card mt-2" id="wrapper-tabla">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0 table-striped table-hover" id="tabla"></table>
                </div>
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
    window.pyrus = new Pyrus("productos", null, src);
    window.elementos = @json($productos);
    window.select2 = @json($select2);
    submitProducto = function(t) {
        let necesario = [
            {name:"codigo",nombre:"CÓDIGO"},
            {name:"nombre",nombre:"NOMBRE"},
            {name:"cantidad",nombre:"CANTIDAD"},
            {name:"categoria_id",nombre:"CATEGORÍA"},
            {name:"origen_id",nombre:"ORIGEN"},
            {name:"marca_id",nombre:"MARCA / MODELO"}
        ];
        let flag = true;
        let necesarioTEXT = "";
        necesario.forEach(function(n) {
            if(n.name == "nombre") {
                if(CKEDITOR.instances[n.name].getData() == "") {
                    flag = false;
                    if(necesarioTEXT != "") necesarioTEXT += ", ";
                    necesarioTEXT += n.nombre;
                }
            } else {
                if($(`#${n.name}`).length) {
                    if($(`#${n.name}`).val() == "") {
                        flag = false;
                        if(necesarioTEXT != "") necesarioTEXT += ", ";
                        necesarioTEXT += n.nombre;
                    }
                }
            }
        });
        if(flag)
            document.getElementById('form').submit();
        else
            alertify.notify(`Faltan datos necesarios: ${necesarioTEXT}`, 'error');
    }
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
    /** ------------------------------------- */
    edit = function(t, id) {
        $(t).attr("disabled",true);
        let promise = new Promise(function (resolve, reject) {
            let url = `{{ url('/adm/${window.pyrus.entidad}/edit/${id}') }}`;
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
                    $(t).removeAttr("disabled");
                    add($("#btnADD"),parseInt(id),data);
                })
        };
        promiseFunction();
    };
    /** ------------------------------------- */
    remove = function(t) {
        add($("#btnADD"));

        for(let x in window.pyrus.especificacion) {
            if(window.pyrus.especificacion[x].EDITOR !== undefined) {
                if(CKEDITOR.instances[x] !== undefined)
                    CKEDITOR.instances[x].setData('');
                continue;
            }
            if(window.pyrus.especificacion[x].TIPO == "TP_FILE") {
                $(`#src-${x}`).attr("src","");
                continue;
            }
            if(x == "familia_id" || x == "categoria_id" || x == "origen_id" || x == "marca_id") {
                if(window[`set_${x}`] !== undefined) {
                    delete window[`set_${x}`];
                    $(`[name="${x}"]`).val("").trigger("change");
                }
                continue;
            }
            $(`[name="${x}"]`).val("");
        }
    };
    
    formatSelect2 = function(data) {
        if (!data.id) return data.text; // optgroup
        return `<img style="${data.style !== undefined ? data.style : ""}" class="flag mr-2" src="{{ asset('${data.img}') }}"/> ${data.text}`;
    }
    changeFamilia = function(t, target) {
        let id = $(t).val();
        
        let promise = new Promise(function (resolve, reject) {
            let url = `{{ url('/adm/categorias/subcategorias/show/${id}') }}`;
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
                .then(function(msg) {
                    $(target).find(`option`).remove();
                    
                    $(target).select2({
                        data: msg,
                        tags: "true",
                        allowClear: true,
                        placeholder: "Seleccione: CATEGORÍA",
                        width: "resolve"
                    });
                    $(target).removeAttr("disabled");
                    if(window.set_categoria_id !== undefined)
                        $(target).val(window.set_categoria_id).trigger("change");
                    if(Object.keys(msg).length == 0)
                        $(target).attr("disabled", true);
                });
        };
        promiseFunction();
    }
    init = function() {
        console.log("CONSTRUYENDO FORMULARIO Y TABLA");
        /** */
        $("#form .container-form").html(window.pyrus.formulario());
        $("#precio").maskMoney({thousands:'.', decimal:',', allowZero:true, prefix: '$ '});
        if($("#form .container-form .select__2").length) {
            
            $("#form .container-form #categoria_id.select__2").select2({
                tags: "true",
                allowClear: true,
                placeholder: "Seleccione: CATEGORÍA",
                width: "resolve"
            });
            $("#form .container-form #marca_id.select__2").select2({
                data: window.select2.modelos,
                tags: "true",
                allowClear: true,
                placeholder: "Seleccione: MODELO",
                width: "resolve"
            });
            $("#form .container-form #familia_id.select__2").select2({
                data: window.select2.familias,
                //formatResult: formatSelect2,
                templateResult: formatSelect2,
                //templateSelection: formatSelect2,
                tags: "true",
                allowClear: true,
                placeholder: "Seleccione: FAMILIA",
                width: "resolve",
                escapeMarkup: function(m) { return m; }
            });
            
            $("#form .container-form #origen_id.select__2").select2({
                data: window.select2.origenes,
                //formatResult: formatSelect2,
                templateResult: formatSelect2,
                templateSelection: formatSelect2,
                tags: "true",
                allowClear: true,
                placeholder: "Seleccione: ORIGEN",
                width: "resolve",
                escapeMarkup: function(m) { return m; }
            });
        }

        let columnas = window.pyrus.columnas();
        let table = $("#tabla");
        columnas.forEach(function(e) {
            if(!table.find("thead").length) 
                table.append('<thead class="thead-dark"></thead>');
            table.find("thead").append(`<th class="${e.CLASS}" style="width:${e.WIDTH}">${e.NAME}</th>`);
        });
        table.find("thead").append(`<th class="text-uppercase text-center" style="width:150px">acción</th>`);

        window.elementos.forEach(function(data) {
            let tr = "";
            if(!table.find("tbody").length) 
                table.append("<tbody></tbody>");
            columnas.forEach(function(c) {
                td = data[c.COLUMN] === null ? "" : data[c.COLUMN];
                if(window.pyrus.especificacion[c.COLUMN].TIPO == "TP_FILE") {
                    date = new Date();
                    img = `{{ asset('${td}') }}?t=${date.getTime()}`;
                    td = `<img style="filter:${data.hsl}" class="w-100" src="${img}" onerror="this.src='${src}'"/>`;
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
                tr += `<td data-${c.COLUMN} class="${c.CLASS}">${td}</td>`;
            });
            tr += `<td class="text-center">`;
                tr += `<button onclick="edit(this,${data.id})" class="btn rounded-0 btn-warning"><i class="fas fa-pencil-alt"></i></button>`;
                tr += `<button onclick="erase(this,${data.id})" class="btn rounded-0 btn-danger"><i class="fas fa-trash-alt"></i></button>`;
            tr += `</td>`;
            table.find("tbody").append(`<tr data-id="${data.id}">${tr}</tr>`);
        });
    }
    /** */
    init();
</script>
@endpush