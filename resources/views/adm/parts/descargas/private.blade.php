<h3 class="title">{{$title}}</h3>

<section class="mt-3">
    <div class="container-fluid">
        <div>
            <button id="btnADD" onclick="add(this,'precio')" class="btn btn-primary text-uppercase" type="button">Agregar <strong>Lista de Precios</strong><i class="fas fa-plus ml-2"></i></button>
        </div>
        <div style="display: none;" id="wrapper-form" class="mt-2">
            <div class="card">
                <div class="card-body">
                    <button onclick="remove(this,'precio')" style="z-index:11;" type="button" class="close position-absolute" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                    <form id="form" novalidate class="pt-2" action="{{ url('/adm/familia/store') }}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center">
                                <button id="btnSubmitPrecio" type="submit" class="btn btn-success text-uppercase w-25">agregar</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 container-form"></div>
                            <div class="col-12 col-md-6">
                                <button id="btnADDext" onclick="addEXT(this)" class="btn btn-info text-uppercase" type="button">Extensión / Formato<i class="fas fa-plus ml-2"></i></button>
                                <div class="container-formEXT"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card mt-2" id="wrapper-tabla">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0" id="tabla"></table>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 container-fluid">
        <div>
            <button id="btnADDcatalogo" onclick="add(this,'catalogo')" class="btn btn-primary text-uppercase" type="button">Agregar <strong>Catálogos</strong><i class="fas fa-plus ml-2"></i></button>
        </div>
        <div style="display: none;" id="wrapper-form2" class="mt-2">
            <div class="card">
                <div class="card-body">
                    <button onclick="remove(this,'catalogo')" style="z-index:11;" type="button" class="close position-absolute" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                    <form id="form2" novalidate class="pt-2" action="{{ url('/adm/familia/store') }}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center">
                                <button id="btnSubmitParte" type="submit" class="btn btn-success text-uppercase w-25">agregar</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 container-form2"></div>
                            <div class="col-12 col-md-6">
                                <button id="btnADDparte" onclick="addPARTE(this)" class="btn px-5 btn-info text-uppercase" type="button">Parte<i class="fas fa-plus ml-2"></i></button>
                                <div class="container-formPARTE"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card mt-2" id="wrapper-tabla2">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0" id="tabla2"></table>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts_distribuidor')
<script>
    const src = "{{ asset('images/general/no-descarga.fw.png') }}";
    window.pyrus = new Pyrus("descargasprecio", null, src);
    window.pyrus2 = new Pyrus("descargasparte", null, src);
    window.elementos = @json($descargasPrecio);
    
    /** ------------------------------------- */
    remove = function(t, tipo) {
        
        if(tipo == "precio") {
            add($("#btnADD"),tipo);
            $(".container-formEXT").html("");

            for(let x in window.pyrus.especificacion) {
                if(window.pyrus.especificacion[x].EDITOR !== undefined) {
                    CKEDITOR.instances[x].setData('');
                    continue;
                }
                if(window.pyrus.especificacion[x].TIPO == "TP_FILE")
                    $(`#src-${x}`).attr("src","");
                $(`[name="${x}"]`).val("");
            }
        } else {
            add($("#btnADDcatalogo"),tipo);
            $(".container-formPARTE").html("");

            for(let x in window.pyrus2.especificacion) {
                if(window.pyrus2.especificacion[x].EDITOR !== undefined) {
                    CKEDITOR.instances[x].setData('');
                    continue;
                }
                if(window.pyrus2.especificacion[x].TIPO == "TP_FILE")
                    $(`#src-${x}`).attr("src","");
                $(`[name="${x}"]`).val("");
            }
        }
    };
    /** ------------------------------------- */
    add = function(t, tipo, id = 0, data = null) {
        let btn = $(t);
        if(btn.is(":disabled"))
            btn.removeAttr("disabled");
        else
            btn.attr("disabled",true);
        if(tipo == "precio") {
            $("#wrapper-form").toggle(800,"swing");

            $("#wrapper-tabla").toggle("fast");

            if(id != 0) {
                action = `{{ url('/adm/descargas/updateEXT/${id}') }}`;
                $("#btnSubmitPrecio").text("Editar");
            } else {
                action = `{{ url('/adm/descargas/storeEXT') }}`;
                $("#btnSubmitPrecio").text("agregar");
            }
            if(data !== null) {
                for(let x in window.pyrus.especificacion) {
                    if(window.pyrus.especificacion[x].TIPO == "TP_FILE") {
                        date = new Date();
                        img = `{{ asset('${data[0][x]}') }}?t=${date.getTime()}`;
                        $(`#src-${x}`).attr("src",img);
                        continue;
                    }
                    $(`[name="${x}"]`).val(data[0][x]);
                }
                data.forEach( function(t) {
                    addEXT($("#btnADDext"), t);
                });
            } else {
                if($("#tabla tbody").length)
                    $("#orden").val($("#tabla tbody").find("tr:last-child() td[data-orden]").text());
                else
                    $("#orden").val("AA");
            }
            elmnt = document.getElementById("form");
            elmnt.scrollIntoView();
            $("#form").attr("action",action);
        }
        if(tipo == "catalogo") {
            $("#wrapper-form2").toggle(800,"swing");

            $("#wrapper-tabla2").toggle("fast");

            if(id != 0) {
                action = `{{ url('/adm/descargas/updatePARTE/${id}') }}`;
                $("#btnSubmitParte").text("Editar");
            } else {
                action = `{{ url('/adm/descargas/storePARTE') }}`;
                $("#btnSubmitParte").text("agregar");
            }
            if(data !== null) {
                for(let x in window.pyrus2.especificacion) {
                    if(window.pyrus2.especificacion[x].TIPO == "TP_FILE") {
                        date = new Date();
                        img = `{{ asset('${data[0].image}') }}?t=${date.getTime()}`;
                        $(`#src-${x}`).attr("src",img);
                        continue;
                    }
                    $(`[name="${x}"]`).val(data[0][x.replace("2","")]);
                }
                data.forEach( function(t) {
                    addPARTE($("#btnADDparte"), t);
                });
            } else {
                if($("#tabla2 tbody").length)
                    $("#orden2").val($("#tabla2 tbody").find("tr:last-child() td[data-orden]").text());
                else
                    $("#orden2").val("AA");
            }
            elmnt = document.getElementById("form2");
            elmnt.scrollIntoView();
            $("#form2").attr("action",action);
        }
    };
    addEXT = function(t, data = null) {
        let ext = new Pyrus("descargasprecioEXT");
        let html = "";
        if(window.extNumber === undefined)
            window.extNumber = 0;
        window.extNumber ++;
        
        html += `<div class="mt-2 position-relative ext">`;
            html += `<span onclick="removeEXT(this)" class="position-absolute p-2 bg-danger text-white" style="right:0; top: 0; z-index: 1; cursor: pointer;"><i class="fas fa-trash"></i></span>`;
            html += `<input type="hidden" value="0" name="idEXT[]"/>`;
            html += ext.formulario(window.extNumber,"ext");
        html += `</div>`;
        $("#form .container-formEXT").append(html);
        if(data !== null) {
            formato = data.formato;
            $("#form .container-formEXT").find("> div:last-child input[type='hidden']").val(data.id);
            $("#form .container-formEXT").find("> div:last-child select").val(formato.toLowerCase()).trigger("change");
        }
    }
    addPARTE = function(t, data = null) {
        let parte = new Pyrus("descargasparteEXT");
        let html = "";
        if(window.parteNumber === undefined)
            window.parteNumber = 0;
        window.parteNumber ++;
        
        html += `<div class="mt-2 position-relative parte">`;
            html += `<span onclick="removePARTE(this)" class="position-absolute p-2 bg-danger text-white" style="right:0; top: 0; z-index: 1; cursor: pointer;"><i class="fas fa-trash"></i></span>`;
            html += `<input type="hidden" value="0" name="idPARTE[]"/>`;
            html += parte.formulario(window.parteNumber,"parte");
        html += `</div>`;
        $("#form2 .container-formPARTE").append(html);
        if(data !== null) {
            $("#form2 .container-formPARTE").find("> div:last-child input[type='hidden']").val(data.id);
            $("#form2 .container-formPARTE").find("> div:last-child input[type='text']").val(data.parte.toLowerCase());
        }
    }

    removeEXT = function(t) {
        $(t).closest(".ext").remove();
    };
    removePARTE = function(t) {
        $(t).closest(".parte").remove();
    };
    /** ------------------------------------- */
    erase = function(t, id, tipo) {
        $(t).attr("disabled",true);
        alertify.confirm("ATENCIÓN","¿Eliminar registro?",
            function(){
                let promise = new Promise(function (resolve, reject) {
                    let url = null;
                    if(tipo == "precio")
                        url = `{{ url('/adm/descargas/deleteEXT/${id}') }}`;
                    else
                        url = `{{ url('/adm/descargas/deletePARTE/${id}') }}`
                    var xmlHttp = new XMLHttpRequest();
                    xmlHttp.open( "GET", url, true );
                    
                    xmlHttp.send( null );
                    resolve(xmlHttp.responseText);
                });

                promiseFunction = () => {
                    promise
                        .then(function(msg) {
                            $("table").find(`tr[data-id="${id}"]`).remove();
                        })
                };
                promiseFunction();
            },
            function() {
                $(t).removeAttr("disabled");
            }
        ).set('labels', {ok:'Confirmar', cancel:'Cancelar'});
    };
    
    /** ------------------------------------- */
    edit = function(t, id, tipo) {
        $(t).attr("disabled",true);
        let promise = new Promise(function (resolve, reject) {
            let url = `{{ url('/adm/descargas/show/${id}') }}`;
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
                    if(tipo == "precio")
                        add($("#btnADD"),tipo,parseInt(id),data);
                    else
                        add($("#btnADDcatalogo"),tipo,parseInt(id),data);
                })
        };
        promiseFunction();
    };
    /** ------------------------------------- */
    init = function() {
        console.log("CONSTRUYENDO FORMULARIO Y TABLA");
        /** */
        $("#form .container-form").html(window.pyrus.formulario());
        $("#form2 .container-form2").html(window.pyrus2.formulario());
        
        let columnas = window.pyrus.columnas();
        let columnas2 = window.pyrus2.columnas();
        let table = $("#tabla");
        let table2 = $("#tabla2");
        columnas.forEach(function(e) {
            if(!table.find("thead").length) 
                table.append('<thead class="thead-dark"></thead>');
            table.find("thead").append(`<th class="${e.CLASS}" style="width:${e.WIDTH}">${e.NAME}</th>`);
        });
        table.find("thead").append(`<th class="text-uppercase text-center" style="width:150px">acción</th>`);
        
        columnas2.forEach(function(e) {
            if(!table2.find("thead").length) 
                table2.append('<thead class="thead-dark"></thead>');
            table2.find("thead").append(`<th class="${e.CLASS}" style="width:${e.WIDTH}">${e.NAME}</th>`);
        });
        table2.find("thead").append(`<th class="text-uppercase text-center" style="width:150px">acción</th>`);

        for(let x in window.elementos[1]) {
            let tr = "";
            let data = window.elementos[1][x];
            if(!table.find("tbody").length) 
                table.append("<tbody></tbody>");
            columnas.forEach(function(c) {
                td = data[c.COLUMN] === null ? "" : data[c.COLUMN];
                if(c.COLUMN == "documento") {
                    ARR = td;
                    td = "";
                    ARR.forEach(function(d) {
                        if(d !== null) {
                            file = `{{ asset('${d}') }}`;
                            td += `<p class="mb-0"><a class="text-uppercase text-primary" href="${file}" target="blank">documento<i class="fas fa-external-link-alt ml-1"></i></a></p>`;
                        }
                    });
                } else if(window.pyrus.especificacion[c.COLUMN].TIPO == "TP_FILE") {
                    date = new Date();
                    img = `{{ asset('${td}') }}?t=${date.getTime()}`;
                    td = `<img class="w-100" src="${img}" onerror="this.src='${src}'"/>`;
                }
                tr += `<td data-${c.COLUMN} class="${c.CLASS}">${td}</td>`;
            });
            //tr += `<td class="text-uppercase">${data.precio ? "lista de precios" : "catálogo"}</td>`;
            tr += `<td class="text-center"><button onclick="edit(this,${data.id},'precio')" class="btn rounded-0 btn-warning"><i class="fas fa-pencil-alt"></i></button><button onclick="erase(this,${data.id},'precio')" class="btn rounded-0 btn-danger"><i class="fas fa-trash-alt"></i></button></td>`;
            table.find("tbody").append(`<tr data-id="${data.id}">${tr}</tr>`);
        };
        for(let x in window.elementos[0]) {
            let tr = "";
            let data = window.elementos[0][x];
            if(!table2.find("tbody").length) 
                table2.append("<tbody></tbody>");
            columnas2.forEach(function(c) {
                col = c.COLUMN.replace("2","");
                console.log(col)
                td = data[col] === null ? "" : data[col];
                if(col == "documento") {
                    ARR = td;
                    td = "";
                    ARR.forEach(function(d) {
                        if(d !== null) {
                            file = `{{ asset('${d}') }}`;
                            td += `<p class="mb-0"><a class="text-uppercase text-primary" href="${file}" target="blank">documento<i class="fas fa-external-link-alt ml-1"></i></a></p>`;
                        }
                    });
                } else if(window.pyrus2.especificacion[c.COLUMN].TIPO == "TP_FILE") {
                    date = new Date();
                    img = `{{ asset('${td}') }}?t=${date.getTime()}`;
                    td = `<img class="w-100" src="${img}" onerror="this.src='${src}'"/>`;
                }
                tr += `<td data-${col} class="${c.CLASS}">${td}</td>`;
            });
            //tr += `<td class="text-uppercase">${data.precio ? "lista de precios" : "catálogo"}</td>`;
            tr += `<td class="text-center"><button onclick="edit(this,${data.id},'catalogo')" class="btn rounded-0 btn-warning"><i class="fas fa-pencil-alt"></i></button><button onclick="erase(this,${data.id},'precio')" class="btn rounded-0 btn-danger"><i class="fas fa-trash-alt"></i></button></td>`;
            table2.find("tbody").append(`<tr data-id="${data.id}">${tr}</tr>`);
        };
    };
    init();
</script>
@endpush