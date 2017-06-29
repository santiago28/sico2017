$(document).ready(function () {
$('.encuentroSede').change(function() {
    var encuentroSede = $(this).val();
    $selector = $(this).parent().parent().next();
    if(encuentroSede == 2){
        $selector.removeClass("hidden");
        $selector.find(".servicio").removeClass("hidden").addClass("required");
        $selector.find(".servicio").removeAttr("disabled");
    } else {
        $selector.addClass("hidden");
        $selector.find(".servicio").attr("disabled", "disabled");
        $selector.find(".servicio").removeClass("required").addClass("hidden");
    }
});
});