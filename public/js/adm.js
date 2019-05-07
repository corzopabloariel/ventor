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