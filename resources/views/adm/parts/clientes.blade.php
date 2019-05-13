<div class="modal fade bd-example-modal-sm" role="dialog" id="modalCliente">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>
<h3 class="title">{{$title}}</h3>

<section class="mt-3">
    <div class="container-fluid">
        <div style="display: none;" id="wrapper-form">
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
<script src="{{ asset('js/bootstrap-input-spinner.js') }}"></script>
<script>
    window.pyrus = new Pyrus("clientes");
    window.elementos = @json($usuarios);
    
    edit = function(t,id,tipo) {
        let modal = $("#modalCliente");
        let html = "";
        switch(tipo) {
            case "porcentaje":
                actual = $(`table tbody tr[data-id="${id}"]`).find("td:nth-child(4)").text();
                html += `<input data-suffix="%" value="${actual}" min="0" max="100" type="number" step="1" />`;
                modal.find(".modal-body").html(html);
                if(modal.find("input[type='number']").length) {
                    let config = {
                        decrementButton: '<i class="fas fa-minus"></i>',
                        incrementButton: '<i class="fas fa-plus"></i>',
                        buttonsClass: "btn-outline-secondary btn-sm",
                        buttonsWidth: "1.5rem",
                    }
                    modal.find( "input[type='number']" ).inputSpinner(config);
                }
            break;
        }
        modal.modal("show");
    }
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
            tr += `<td class="text-center">`;
                tr += `<button onclick="edit(this,${data.id},'password')" class="btn rounded-0 btn-warning"><i class="fas fa-key"></i></button>`;
                tr += `<button onclick="edit(this,${data.id},'porcentaje')" class="btn rounded-0 btn-info"><i class="fas fa-percentage"></i></button>`;
                tr += `<button onclick="erase(this,${data.id})" class="btn rounded-0 btn-danger"><i class="fas fa-trash-alt"></i></button>`;
            tr += `</td>`;
            table.find("tbody").append(`<tr data-id="${data.id}">${tr}</tr>`);
        });
    }
    /** */
    init();
</script>
@endpush