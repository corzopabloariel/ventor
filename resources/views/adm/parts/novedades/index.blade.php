<h3 class="title">{{$title}}</h3>

<section class="mt-3">
    <div class="container-fluid">
        <div class="d-flex">
            <button id="btnADD" onclick="add(this)" class="btn btn-primary text-uppercase" type="button">Agregar<i class="fas fa-plus ml-2"></i></button>
            <button onclick="guardarOrden()" class="btn btn-dark ml-2 text-uppercase">guardar orden</button>
        </div>
        <div class="alert alert-primary mt-2" id="mensajeSorteable" role="alert">
            Arrastre los elementos de la tabla para ordenarlos
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
            </div>
        </div>
    </div>
</section>
@push('scripts_distribuidor')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    const src = "{{ asset('images/general/no-img.png') }}";
    window.pyrus = new Pyrus("novedades", null, src);
    window.elementos = @json($novedades);
    
    guardarOrden = function() {
        alertify.confirm("ATENCIÓN","¿Confirma el orden de los elementos?",
            function() {
                let arr = [];
                $("#tabla tbody tr").each(function() {
                    arr.push($(this).data("id"));
                });
                let formData = new FormData();
                formData.append("_token", "{{csrf_token()}}");
                formData.append("ids", JSON.stringify(arr));

                let url = `{{ url('/adm/${window.pyrus.entidad}/orden/') }}`;
                var xmlHttp = new XMLHttpRequest();

                xmlHttp.open( "POST", url, true );
                xmlHttp.onload = function() {
                    alertify.success("Orden guardado correctamente");
                }
                xmlHttp.send( formData );
            },
            function() {}
        ).set('labels', {ok:'Confirmar', cancel:'Cancelar'});
    }

    /** ------------------------------------- */
    add = function(t, id = 0, data = null) {
        let btn = $(t);
        if(btn.is(":disabled"))
            btn.removeAttr("disabled");
        else
            btn.attr("disabled",true);
        $("#wrapper-form").toggle(800,"swing");
        
        $("#wrapper-tabla,#mensajeSorteable").toggle("fast");

        if(id != 0)
            action = `{{ url('/adm/${window.pyrus.entidad}/update/${id}') }}`;
        else {
            action = `{{ url('/adm/${window.pyrus.entidad}/store') }}`;
            $("#orden").val("AA");
            if($("#tabla").find("tbody").length) {
                if($("#tabla").find("tbody tr").length)
                    $("#orden").val($("#tabla").find("tbody tr:last-child td[data-orden]").text());
            }
        }
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
                $(`[name="${x}"]`).val(data[x]);
            }
        }
        elmnt = document.getElementById("form");
        elmnt.scrollIntoView();
        $("#form").attr("action",action);
    };
    /** ------------------------------------- */
    erase = function(t, id) {
        $(t).attr("disabled",true);
        alertify.confirm("ATENCIÓN","¿Eliminar registro?",
            function(){
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
            },
            function() {
                $(t).removeAttr("disabled");
            }
        ).set('labels', {ok:'Confirmar', cancel:'Cancelar'});
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
    /** ------------------------------------- */
    init = function() {
        console.log("CONSTRUYENDO FORMULARIO Y TABLA");
        /** */
        $("#form .container-form").html(window.pyrus.formulario());

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
                    td = `<img class="w-100" src="${img}" onerror="this.src='${src}'"/>`;
                }
                tr += `<td class="${c.CLASS}">${td}</td>`;
            });
            tr += `<td class="text-center"><button onclick="edit(this,${data.id})" class="btn rounded-0 btn-warning"><i class="fas fa-pencil-alt"></i></button><button onclick="erase(this,${data.id})" class="btn rounded-0 btn-danger"><i class="fas fa-trash-alt"></i></button></td>`;
            table.find("tbody").append(`<tr class="trSortable" data-id="${data.id}">${tr}</tr>`);
        });
    }
    /** */
    init();

    
    $("#tabla tbody").sortable({
        axis: "y",
        revert: true,
        scroll: false,
        placeholder: "sortable-placeholder",
        cursor: "move"
    }).disableSelection();
    $("#tabla tbody").draggable({
        start: function( event, ui ) {
            $(this).find("tr").addClass('trSortable');
        },
        stop: function( event, ui ) {
            $(this).find("tr").removeClass('trSortable'); 
        }
    });
</script>
@endpush