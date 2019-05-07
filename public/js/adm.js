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
}