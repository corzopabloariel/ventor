<div class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" id="hijosModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<h3 class="title">{{$title}}</h3>

<section class="mt-3">
    <div class="container-fluid">
        <div>
            <button id="btnADD" onclick="add(this)" class="btn btn-primary text-uppercase" type="button">Agregar<i class="fas fa-plus ml-2"></i></button>
        </div>
        <div class="alert alert-warning mt-2" role="alert">
            Permite enlazar las familias y partes del sistema actual con las nuevas (visibles en la zona pública).
        </div>
        <div style="display: none;" id="wrapper-form" class="mt-2">
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
                    <table class="table mb-0" id="tabla"></table>
                </div>
                <div class="mt-2">
                    {{ $categorias->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts_distribuidor')
<script>
    const src = "{{ asset('images/general/no-img.png') }}";
    window.familiasV = @json($familiasV);
    window.pyrus = new Pyrus("categorias", {familia_id:{ DATA : window.familiasV, TIPO: "OP"}}, src);
    window.elementos = @json($categorias);
    
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
            for(let x in window.pyrus.especificacion) {
                if(window.pyrus.especificacion[x].EDITOR !== undefined) {
                    CKEDITOR.instances[`${x}_es`].setData(data[x]);
                    continue;
                }
                if(window.pyrus.especificacion[x].TIPO == "TP_FILE") {
                    date = new Date();
                    img = `{{ asset('${data[x]}') }}?t=${date.getTime()}`;
                    $(`#src-${x}`).attr("src",img);
                    continue;
                }
                $(`[name="${x}"]`).val(data[x]).trigger("change");
            }
            $("#src-image").attr("style",`filter:${data.hsl}`);
        } else {
            if($("#tabla tbody").length)
                $("#orden").val($("#tabla tbody").find("tr:last-child() td[data-orden]").text());
            else
                $("#orden").val("AA");
        }
        elmnt = document.getElementById("form");
        elmnt.scrollIntoView();
        $("#form").attr("action",action);
    };
    addModal = function(t, id = 0, data = null) {
        let btn = $(t);
        if(btn.is(":disabled")){
            btn.removeAttr("disabled");
        } else {
            btn.attr("disabled",true);
        }
        $("#wrapper-formModal").toggle(800,"swing");

        $("#wrapper-tablaModal").toggle("fast");

        if(id != 0)
            action = `{{ url('/adm/${window.pyrus.entidad}/${window.subcategorias.entidad}/update/${id}') }}`;
        else
            action = `{{ url('/adm/${window.pyrus.entidad}/${window.subcategorias.entidad}/store') }}`;
        if(data !== null) {
            
            for(let x in window.subcategorias.especificacion) {
                if(!$(`[name="${x}_sub"]`).length) continue;
                if(x == "padre_id") {//MODELO
                    if(data.tipo == 2)
                        window.padreID = data.modelo;
                    else if(data.tipo == 3) {
                        window.padreID = data.padre.padre.id
                        window.categoriaID = data.padre_id;
                    }
                    continue;
                }
                if(x == "familia_id") {//FAMILIA
                    window.familiaID = data[x];
                    continue;
                }
                if(window.subcategorias.especificacion[x].EDITOR !== undefined) {
                    CKEDITOR.instances[`${x}_es`].setData(data[x]);
                    continue;
                }
                if(window.subcategorias.especificacion[x].TIPO == "TP_FILE") {
                    date = new Date();
                    img = `{{ asset('${data[x]}') }}?t=${date.getTime()}`;
                    $(`#src-${x}_sub`).attr("src",img);
                    continue;
                }
                if(window.subcategorias.especificacion[x].TIPO == "TP_ENUM") {
                    $(`[name="${x}_sub"]`).val(data[x]).trigger("change");
                    continue;
                }
                $(`[name="${x}_sub"]`).val(data[x]).trigger("change");
            }
        } else {
            if($("#tablaModal tbody").length)
                $("#orden_sub").val($("#tablaModal tbody").find("tr:last-child() td[data-orden]").text());
            else
                $("#orden_sub").val("AA");
        }
        console.log(action)
        elmnt = document.getElementById("formModal");
        elmnt.scrollIntoView();
        $("#formModal").attr("action",action);
    };
    /** ------------------------------------- */
    erase = function(t, id) {
        $(t).attr("disabled",true);
        let promise = new Promise(function (resolve, reject) {
            let url = `{{ url('/adm/${window.pyrus.entidad}/delete/${id}') }}`;
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.open( "GET", url, true );
            
            xmlHttp.send( null );
            resolve(xmlHttp.responseText);
        });

        promiseFunction = () => {
            promise
                .then(function(msg) {
                    $("#tabla").find(`tr[data-id="${id}"]`).remove();
                })
        };
        promiseFunction();
    };
    /** ------------------------------------- */
    remove = function(t) {
        add($("#btnADD"));

        for(let x in window.pyrus.especificacion) {
            if(window.pyrus.especificacion[x].EDITOR !== undefined) {
                CKEDITOR.instances[x].setData('');
                continue;
            }
            if(window.pyrus.especificacion[x].TIPO == "TP_FILE")
                $(`#src-${x}`).attr("src","");
            $(`[name="${x}"]`).val("");
        }
    };
    removeModal = function(t) {
        addModal($("#btnADDmodal"));

        if(window.padreID !== undefined)
            delete window.padreID;
        if(window.modeloID !== undefined)
            delete window.modeloID;
        if(window.categoriaID !== undefined)
            delete window.categoriaID;

        for(let x in window.subcategorias.especificacion) {
            if(window.subcategorias.especificacion[x].EDITOR !== undefined) {
                CKEDITOR.instances[x].setData('');
                continue;
            }
            if(window.subcategorias.especificacion[x].TIPO == "TP_FILE")
                $(`#src-${x}_sub`).attr("src","");
            $(`[name="${x}_sub"]`).val("");
        }
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
                    console.log(data)
                    $(t).removeAttr("disabled");
                    add($("#btnADD"),parseInt(id),data);
                })
        };
        promiseFunction();
    };
    editModal = function(t, id) {
        $(t).attr("disabled",true);
        let promise = new Promise(function (resolve, reject) {
            let url = `{{ url('/adm/${window.pyrus.entidad}/${window.subcategorias.entidad}/edit/${id}') }}`;
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
                    console.log(data)
                    $(t).removeAttr("disabled");
                    addModal($("#btnADDmodal"),parseInt(id),data);
                })
        };
        promiseFunction();
    };
    /** ------------------------------------- */
    submitModal = function(t) {
        let formElement = document.getElementById("formModal");
        let elementForm = new FormData(formElement);
        $("#formModal *").attr("disabled", true);
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.responseType = 'json';
        xmlHttp.open( "POST", t.action );
        xmlHttp.onload = function() {
            console.log(xmlHttp.response);
            $("#formModal *").removeAttr("disabled");
            let table = $("#wrapper-tablaModal table");
            date = new Date();

            if(table.find(`tbody tr[data-id="${xmlHttp.response.id}"]`).length) {
                let tr = table.find(`tbody tr[data-id="${xmlHttp.response.id}"]`);
                img = `{{ asset('${xmlHttp.response.image}') }}?t=${date.getTime()}`;

                tr.find("td:first-child").text(xmlHttp.response.orden);
                tr.find("td:nth-child(2) img").attr("src",img);
                tr.find("td:nth-child(3)").text(xmlHttp.response.nombre);
            } else {
                let columnas = window.subcategorias.columnas();
                tr = "";
                if(!table.find("tbody").length) 
                    table.append("<tbody></tbody>");
                columnas.forEach(function(c) {
                    td = xmlHttp.response[c.COLUMN] === null ? "" : xmlHttp.response[c.COLUMN];
                    if(typeof td == 'object')
                        td = td.nombre;
                    if(window.subcategorias.especificacion[c.COLUMN].TIPO == "TP_FILE") {
                        date = new Date();
                        img = `{{ asset('${td}') }}?t=${date.getTime()}`;
                        td = `<img class="w-100" src="${img}" onerror="this.src='${src}'"/>`;
                    }
                    tr += `<td data-${c.COLUMN} class="${c.CLASS}">${td}</td>`;
                });
                tr += `<td class="text-center">`;
                    tr += `<button onclick="editModal(this,${xmlHttp.response.id})" class="btn  rounded-0 btn-warning"><i class="fas fa-pencil-alt"></i></button>`;
                    tr += `<button onclick="eraseModal(this,${xmlHttp.response.id})" class="btn  rounded-0 btn-danger"><i class="fas fa-trash-alt"></i></button>`;
                    tr += `<button onclick="hijos(this,${xmlHttp.response.id},${xmlHttp.response.tipo}, 1)" type="button" class="btn rounded-0 btn-primary"><i class="fas fa-table" title="Listar hijos"></i></button>`;
                    //tr += `<hr>`;
                tr += `</td>`;
                table.find("tbody").append(`<tr data-id="${xmlHttp.response.id}">${tr}</tr>`);
            }
            removeModal($("#btnADDmodal"));
        }
        xmlHttp.send(elementForm);
        return false;
    }
    /** ------------------------------------- */
    hexToRgb = function(hex) {
        const shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
        hex = hex.replace(shorthandRegex, (m, r, g, b) => {
            return r + r + g + g + b + b;
        });

        const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result
            ? [
            parseInt(result[1], 16),
            parseInt(result[2], 16),
            parseInt(result[3], 16),
            ]
            : null;
    }
    changeColor = function(t, tipo) {
        let rgb = hexToRgb($(t).val());
        let color = new Color(rgb[0], rgb[1], rgb[2]);
        let solver = new Solver(color);
        let result = solver.solve();
        
        $("#hsl").val(result.filter);
        $("#src-image").attr("style",`filter:${result.filter}`);
        if(tipo)
            $("#color").val($(t).val());
        else
            $("#hexcolor").val($(t).val())
    }
    hijos = function(t, id, tipo, conPadre = 0) {
        let target = $("#hijosModal");
        let title = target.find(".modal-title");
        let body = target.find(".modal-body");

        $(t).attr("disabled",true);
        let promise = new Promise(function (resolve, reject) {
            let url = `{{ url('/adm/${window.pyrus.entidad}/show/${id}/${tipo}') }}`;
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
                    window.partesV = data.partes;
                    window.subcategorias = new Pyrus("subcategorias", {categoria_id:{ DATA : window.partesV, TIPO: "OP"}}, src);
                    $(t).removeAttr("disabled");
                    let columnas = window.subcategorias.columnas();
                    title.text(data.nombre);
                    if(data.padre !== null)
                        title.text(conPadre ? `${data.padre.nombre} > ${data.nombre}` : data.nombre);
                    
                    html = "";

                    html += '<div class="d-flex justify-content-between mb-2">';
                        html += '<button id="btnADDmodal" onclick="addModal(this)" class="btn btn-primary text-uppercase" type="button">Agregar<i class="fas fa-plus ml-2"></i></button>';
                        if(conPadre && data.padre !== null)
                            html += `<button onclick="hijos(this, ${data.padre.id}, ${data.padre.tipo})" class="btn btn-dark text-uppercase" type="button">regresar<i class="fas fa-undo-alt ml-2"></i></button>`;
                    html += '</div>';
                    html += `<div class="alert alert-warning mt-2" role="alert">Permite enlazar las partes del sistema actual con las nuevas (visibles en la zona pública).</div>`;
                    html += '<div class="table-responsive" id="wrapper-tablaModal"><table class="table mb-0 table-striped table-hover" id="tablaModal"></table></div>';
                    html += '<div style="display: none;" id="wrapper-formModal" class="mt-2 position-relative">'
                        html += '<button style="right: 0; top: 0;" onclick="removeModal(this)" type="button" class="close position-absolute" aria-label="Close">';
                            html += '<span aria-hidden="true"><i class="fas fa-times"></i></span>';
                        html += '</button>';
                        html += '<form id="formModal" novalidate class="pt-2" onsubmit="event.preventDefault(); submitModal(this)" method="post" enctype="multipart/form-data">';
                            html += '<input type="hidden" name="_token" value="{{ csrf_token() }}" />';
                            html += `<input type="hidden" name="padre_id" value="${data.id}" />`;
                            html += `<input type="hidden" name="tipo" value="${parseInt(tipo) + 1}" />`;
                            html += '<div class="container-formModal"></div>';
                        html += '</form>';
                    html += '</div>';
                    body.html(html);
                    let table = body.find("table");
                    $("#formModal .container-formModal").html(window.subcategorias.formulario("sub"));
                    $("#formModal .container-formModal").find(".select__2").select2({
                        tags: "true",
                        allowClear: true,
                        placeholder: "Seleccione: CATEGORÍA",
                        width: "resolve"
                    });
                    columnas.forEach(function(e) {
                        if(!table.find("thead").length) 
                            table.append('<thead class="thead-dark"></thead>');
                        table.find("thead").append(`<th class="${e.CLASS}" style="width:${e.WIDTH}">${e.NAME}</th>`);
                    });
                    table.find("thead").append(`<th class="text-uppercase text-center" style="width:150px">acción</th>`);
                    
                    data.hijos.forEach(function(data) {
                        let tr = "";
                        if(!table.find("tbody").length) 
                            table.append("<tbody></tbody>");
                        columnas.forEach(function(c) {
                            td = data[c.COLUMN] === null ? "" : data[c.COLUMN];
                            if(typeof td == 'object')
                                td = td.nombre;
                            if(window.subcategorias.especificacion[c.COLUMN].TIPO == "TP_FILE") {
                                date = new Date();
                                img = `{{ asset('${td}') }}?t=${date.getTime()}`;
                                td = `<img class="w-100" src="${img}" onerror="this.src='${src}'"/>`;
                            }
                            tr += `<td data-${c.COLUMN} class="${c.CLASS}">${td}</td>`;
                        });
                        tr += `<td class="text-center">`;
                            tr += `<button onclick="editModal(this,${data.id})" class="btn rounded-0 btn-warning"><i class="fas fa-pencil-alt"></i></button>`;
                            tr += `<button onclick="eraseModal(this,${data.id})" class="btn rounded-0 btn-danger"><i class="fas fa-trash-alt"></i></button>`;
                            //tr += `<button onclick="hijos(this,${data.id},${data.tipo}, 1)" type="button" class="btn rounded-0 btn-primary"><i class="fas fa-table" title="Listar hijos"></i></button>`;
                            //tr += `<hr>`;
                        tr += `</td>`;
                        table.find("tbody").append(`<tr data-id="${data.id}">${tr}</tr>`);
                    });
                    target.modal("show");
                })
        };
        promiseFunction();
    }
    init = function() {
        console.log("CONSTRUYENDO FORMULARIO Y TABLA");
        /** */
        $("#form .container-form").html(window.pyrus.formulario());
        $("#familia_id").select2({
            tags: "true",
            allowClear: true,
            placeholder: "Seleccione: FAMILIA",
            width: "resolve"
        });
        let columnas = window.pyrus.columnas();
        let table = $("#tabla");
        columnas.forEach(function(e) {
            if(!table.find("thead").length) 
                table.append('<thead class="thead-dark"></thead>');
            table.find("thead").append(`<th class="${e.CLASS}" style="width:${e.WIDTH}">${e.NAME}</th>`);
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
                    img = `{{ asset('${td}') }}?t=${date.getTime()}`;
                    td = `<img style="filter:${data.hsl}" class="w-100" src="${img}" onerror="this.src='${src}'"/>`;
                }
                if(window.pyrus.especificacion[c.COLUMN].TIPO == "TP_COLOR") {
                    td = `${td}<div class="mt-1" style="height:10px; background: ${td}"></div>`;
                }
                tr += `<td data-${c.COLUMN} class="${c.CLASS}">${td}</td>`;
            });
            tr += `<td class="text-center">`;
                tr += `<button onclick="edit(this,${data.id})" class="btn rounded-0 btn-warning"><i class="fas fa-pencil-alt"></i></button>`;
                tr += `<button onclick="erase(this,${data.id})" class="btn rounded-0 btn-danger"><i class="fas fa-trash-alt"></i></button>`;
                tr += `<button onclick="hijos(this,${data.id},${data.tipo}, 1)" type="button" class="btn rounded-0 btn-primary"><i class="fas fa-table" title="Listar hijos"></i></button>`;
            tr += `</td>`;
            table.find("tbody").append(`<tr data-id="${data.id}">${tr}</tr>`);
        });
    }
    /** */
    init();
</script>
@endpush