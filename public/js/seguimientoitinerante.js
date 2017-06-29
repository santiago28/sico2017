var url = window.location.protocol + "//" + window.location.host + "/sico/" + "cob_actaconteo/seguimientoitinerante/" + $("#seguimientoitinerante_form table").attr("id");
$( '#seguimientoitinerante_form' ).parsley( 'destroy' );
$( '#seguimientoitinerante_form' ).parsley();
//initialize input widgets first
$('td .time').timepicker({
    'showDuration': true,
    'timeFormat': 'g:iA',
    'minTime': '8:00am',
    'maxTime': '6:00pm',
    'step': 15
});
$(".eliminar_guardado").click (
	function(){
		eliminar_guardado($(this));
});
$(document).ready(function(){
	$(".eliminar_valor").click(
        function(){
        	eliminar_valor($(this));
        }
    );
});
function eliminar_guardado(elemento){
	var id = $(elemento).attr("id");
	var empleados_eliminar = $("#eliminar_empleados").val();
	if(empleados_eliminar.length > 0){
	$("#eliminar_empleados").val(empleados_eliminar+","+id);
	} else { $("#eliminar_empleados").val(id); }
	$(elemento).parent().parent().remove();
}
$(".editar_guardado").click(
    function(){
    	var id = $(this).parent().find(".eliminar_guardado").attr("id");
    	var empleados_eliminar = $("#eliminar_empleados").val();
    	if(empleados_eliminar.length > 0){
    	$("#eliminar_empleados").val(empleados_eliminar+","+id);
    	} else { $("#eliminar_empleados").val(id); }
    	$(this).parent().parent().find("input").removeAttr("disabled");
    	$(this).parent().parent().find("textarea").removeAttr("disabled");
    	$(this).parent().parent().find("select").removeAttr("disabled");
    	$( '#seguimientoitinerante_form' ).parsley( 'destroy' );
    	$( '#seguimientoitinerante_form' ).parsley();
    }
);
$("td .editar").click(
    function(){
    	$(this).parent().parent().find("input").removeAttr("disabled");
    	$(this).parent().parent().find("textarea").removeAttr("disabled");
    	$(this).parent().parent().find("select").removeAttr("disabled");
    	$( '#seguimientoitinerante_form' ).parsley( 'destroy' );
    	$( '#seguimientoitinerante_form' ).parsley();
    }
);

$('.submit_empleados').click(function() {
	submit_empleados();
});
function submit_empleados() {
	$("table").find(".error_documento").html("");
	var error = 0;
	$(".numDocumento[disabled!='disabled']").each(function() {
		var tr = $(this).parent();
    	var encontrados = 0;
    	var numDocumento = $(this).val();
    	$(".num_documento[disabled!='disabled']").each(function() {
        	var num_documento2 = $(this).val();
        	if(num_documento == num_documento2){
							encontrados = encontrados + 1;
        	}
        });
    	if(encontrados > 1){
			tr.find(".error_documento").html("<ul class='parsley-error-list'><li class='required' style='display: list-item;'>Este campo se encuentra duplicado.</li></ul>");
			error = 1;
    	}
    });
	if(error == 0){
		if($( 'form' ).parsley( 'validate' )){
			$('form').submit();
		}
	}
}
