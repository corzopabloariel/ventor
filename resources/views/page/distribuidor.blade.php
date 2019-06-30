@extends('page.main')

@section('body')
    @include($view)
@endsection

@push('scripts')
<script>
    if(localStorage.utilidadON !== undefined) {
        $("[data-carrito] > a").addClass("isDisabled");
        $("[data-carrito] > a").attr("disabled", true);
    }
    $(document).ready(function() {
        new WOW().init();
        $("body").on("click",".alert button.close", function() {
            $(this).closest(".alert").remove();
        });
        if($("#utilidad").length) {
            $("#utilidad").maskMoney({thousands:'.', decimal:',', allowZero:true, suffix: ''});
            $("#utilidad").focus();
            localStorage.setItem("utilidad", parseFloat($('#utilidad').maskMoney('unmasked')[0]));
        }
    });
    confirguracionMarkUP = function(t) {
        if($("#menuNav").is(":visible"))
            $("#menuNav").modal("hide");
        $("#markupConf").modal("show");
    };
    
    edifConfiguracion = function(t) {
        let idForm = t.id;
        let url = t.action;

        let formElement = document.getElementById(idForm);
        let request = new XMLHttpRequest();
        let formData = new FormData(formElement);

        formData.set("utilidad", $('#utilidad').maskMoney('unmasked')[0]);
        window.localStorage.setItem("utilidad",$('#utilidad').maskMoney('unmasked')[0]);

        request.responseType = 'json';
        let xmlHttp = new XMLHttpRequest();
        xmlHttp.open( "POST", url );
        xmlHttp.onload = function() {
            $("#markupConf").modal("hide");
            alertify.success("Porcentaje de utilidad modificados");

            if(localStorage.utilidadON !== undefined) {
                $('input:radio[name="markup"][value="costo"]').prop('checked',true)
                $("input:radio[name='markup'][value='costo']").trigger("change");
            }
            console.log(xmlHttp.response);
        }
        xmlHttp.send( formData );
    };
</script>
@stack('scripts_distribuidor')
@endpush