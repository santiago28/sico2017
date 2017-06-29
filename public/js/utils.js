$("[rel='tooltip']").tooltip();
$(".eliminar_fila").click (
    function(){
    	var enlace = $(this).attr("id");
    	var id_eliminar = $(this).attr("data-id");
    	$(".fila_eliminar").html(id_eliminar);
    	$(".id_elemento").val(id_eliminar);
    	$("#boton_eliminar").attr("href", enlace);
    }
);
$(".alert").fadeOut();
$(".alert").fadeIn();
$(".alert").fadeOut();
$(".alert").fadeIn();
$(".alert").fadeOut();
$(".alert").fadeIn();
$(".alert").fadeOut();
$(".alert").fadeIn();
$(".alert").fadeOut();
$(".alert").fadeIn();
