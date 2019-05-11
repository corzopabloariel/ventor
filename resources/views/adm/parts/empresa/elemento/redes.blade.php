<div>
    <button id="btnADD" onclick="add(this)" class="btn btn-primary text-uppercase" type="button">Agregar<i class="fas fa-plus ml-2"></i></button>
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

@push('scripts_distribuidor')
<script>
    window.pyrus = new Pyrus("redes");
    window.elementos = @json($redes);

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
            action = `{{ url('/adm/empresa/${window.pyrus.entidad}/update/${id}') }}`;
        else
            action = `{{ url('/adm/empresa/${window.pyrus.entidad}/store') }}`;
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
            resolve(window.elementos[id]);
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
        let ARR_redes = {facebook:'<i class="fab fa-facebook-square"></i>',instagram:'<i class="fab fa-instagram"></i>',twitter:'<i class="fab fa-twitter-square"></i>',youtube:'<i class="fab fa-youtube"></i>',linkedin:'<i class="fab fa-linkedin-in"></i>'};
        columnas.forEach(function(e) {
            if(!table.find("thead").length) 
                table.append('<thead class="thead-dark"></thead>');
            table.find("thead").append(`<th class="${e.CLASS}" style="width:${e.WIDTH}">${e.NAME}</th>`);
        });
        table.find("thead").append(`<th class="text-uppercase text-center" style="width:150px">acción</th>`);
        

        for(let x in window.elementos) {
            let tr = "";
            let data = window.elementos[x];
            if(!table.find("tbody").length) 
                table.append("<tbody></tbody>");
            columnas.forEach(function(c) {
                td = data[c.COLUMN] === null ? "" : data[c.COLUMN];
                if(c.COLUMN == "redes") {
                    td = `${ARR_redes[data[c.COLUMN]]} ${data[c.COLUMN]}`;
                }
                tr += `<td data-${c.COLUMN} class="${c.CLASS}">${td}</td>`;
            });
            tr += `<td class="text-center"><button onclick="edit(this,${x})" class="btn rounded-0 btn-warning"><i class="fas fa-pencil-alt"></i></button><button onclick="erase(this,${x})" class="btn rounded-0 btn-danger"><i class="fas fa-trash-alt"></i></button></td>`;
            table.find("tbody").append(`<tr data-id="${x}">${tr}</tr>`);
        }
    }
    /** */
    init();
</script>
@endpush