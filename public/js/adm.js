alertify.defaults.transition = "slide";
alertify.defaults.theme.ok = "btn btn-primary";
alertify.defaults.theme.cancel = "btn btn-danger";
alertify.defaults.theme.input = "form-control";
/** ------------------------------------- */
readURL = function(input, target) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(`#${target}`).attr(`src`,`${e.target.result}`);
        };
        reader.readAsDataURL(input.files[0]);
    }
};
/** ------------------------------------- */
hexcolorChange = function(t,id) {
    $(`#${id}`).val($(t).val());
};
formatter = new Intl.NumberFormat('es-AR', {
    style: 'currency',
    currency: 'ARS',
});
changeMarkUp = function(t) {
    if(t === null) {
        $("[data-precio]").each(function() {
            let precio = parseFloat($(this).data("precio"));
            let utilidadValor = parseFloat(localStorage.utilidad);
            $(this).find("[data-precio]").text(formatter.format( precio + ( precio * (utilidadValor / 100) ) ));
        });
        return false;
    }
    if(t.value == "venta") {
        $(".addpedido").attr("disabled", true);
        $("[data-carrito] > a").addClass("isDisabled");
        $("[data-carrito] > a").attr("disabled", true);
        localStorage.setItem("utilidadON",1);
        $("[data-precio]").each(function() {
            let precio = parseFloat($(this).data("precio"));
            let utilidadValor = parseFloat(localStorage.utilidad);
            $(this).find("[data-precio]").text(formatter.format( precio + ( precio * (utilidadValor / 100) ) ));
        });
    } else {
        localStorage.removeItem("utilidadON");
        $(".addpedido").removeAttr("disabled");
        $("[data-carrito] > a").removeClass("isDisabled");
        $("[data-carrito] > a").removeAttr("disabled");
        $("[data-precio]").each(function() {
            let precio = parseFloat($(this).data("precio"));
            $(this).find("[data-precio]").text(formatter.format( precio ));
        });
    }
};