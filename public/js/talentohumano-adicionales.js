$( '#adicionales_form' ).parsley( 'destroy' );
$( '#adicionales_form' ).parsley();
reasignar_keys();
$(".eliminar_guardado").click (
	function(){
		eliminar_guardado($(this));
});
$("#btn_varios_items").click (
	function() {
		var n_filas = $( ".num_documento[disabled!='disabled']" ).size();
    	if(n_filas >= 20){
	    	$(".alerta_lote").html("<i class='glyphicon glyphicon-warning-sign'></i> Sólo puedes guardar adicionales en lotes de 20, por favor diligencia los campos y presiona el botón 'Guardar' para agregar más adicionales.");
	    	$(".alerta_lote").fadeOut();
	    	$(".alerta_lote").fadeIn();
	    	return;
    	} else {
        	var x2 = 20 - n_filas;
        	$('#n_items').autoNumeric('init', {vMin: '0', vMax: x2 }); /* Doc: https://github.com/BobKnothe/autoNumeric */
        	$('.n2').html(x2);
    		$('#agregar_items').modal('show');
    	}
});
$("#agregar_item_adicional").click (
    function() {
    	agregar_item($(this));
    	$(".eliminar_valor").click(
    	        function(){
    	        	eliminar_valor($(this));
    	        }
    	 );
	});
$(".agregar_varios_items").click (
	function() {
		var n_items = $("#n_items").val();
		for (var l=0;l<n_items;l++) {
			agregar_item($(this));
		}
});

$(document).ready(function(){
	$(".eliminar_valor").click(
        function(){
        	eliminar_valor($(this));
        }
    );
});
$(".editar_guardado").click(
    function(){
    	var id = $(this).parent().find(".eliminar_guardado").attr("id");
    	var adicionales_eliminar = $("#eliminar_adicionales").val();
    	if(adicionales_eliminar.length > 0){
    	$("#eliminar_adicionales").val(adicionales_eliminar+","+id);
    	} else { $("#eliminar_adicionales").val(id); }
			$(this).parent().parent().find(".texto").addClass("hide");
    	$(this).parent().parent().find("input").removeAttr("disabled");
			$(this).parent().parent().find("input").removeClass("hide");
    	$(this).parent().parent().find("textarea").removeAttr("disabled");
			$(this).parent().parent().find("textarea").removeClass("hide");
    	$(this).parent().parent().find("select").removeAttr("disabled");
			$(this).parent().parent().find("select").removeClass("hide");
    	$( '#adicionales_form' ).parsley( 'destroy' );
    	$( '#adicionales_form' ).parsley();
    	reasignar_keys();
    }
);
function si_no_na(val){
	if(val == "Sí"){
		return 1;
	} else if(val == "No") {
		return 2;
	} else if(val == "N/A") {
		return 3;
	}
}
function reasignar_keys(){
	var i = 1;
	$(".num_documento[disabled!='disabled']").each(function() {
    	$(this).parent().parent().find(".number").html(i);
    	i++;
	});
}
function eliminar_guardado(elemento){
	var id = $(elemento).attr("id");
	var adicionales_eliminar = $("#eliminar_adicionales").val();
	if(adicionales_eliminar.length > 0){
	$("#eliminar_adicionales").val(adicionales_eliminar+","+id);
	} else { $("#eliminar_adicionales").val(id); }
	$(elemento).parent().parent().remove();
}
function agregar_item(valor) {
	var n_filas = $( ".num_documento[disabled!='disabled']" ).size();
	if(n_filas !== 20){
		$('#adicionales_form tbody tr:hidden:first').find("input").removeAttr("disabled");
		$('#adicionales_form tbody tr:hidden:first').find("select").removeAttr("disabled");
		$('#adicionales_form tbody tr:hidden:first').find("textarea").removeAttr("disabled");
		$('#adicionales_form tbody tr:hidden:first').removeAttr("style");
		$( '#adicionales_form' ).parsley( 'destroy' );
		$( '#adicionales_form' ).parsley();
		reasignar_keys();
	} else {
		$(".alerta_lote").html("<i class='glyphicon glyphicon-warning-sign'></i> Sólo puedes guardar adicionales en lotes de 20, por favor diligencia los campos y presiona el botón 'Guardar' para agregar más adicionales.");
		$(".alerta_lote").fadeOut();
    	$(".alerta_lote").fadeIn();
	}
}
function eliminar_valor(valor){
	$(valor).parent().parent().find("input").attr("disabled", "disabled");
	$(valor).parent().parent().find("select").attr("disabled", "disabled");
	$(valor).parent().parent().find("textarea").attr("disabled", "disabled");
  $(valor).parent().parent().hide();
  $( '#adicionales_form' ).parsley( 'destroy' );
	$( '#adicionales_form' ).parsley();
	reasignar_keys();
}
$('.submit_adicionales').click(function() {
	submit_adicionales();
});
var empleados_html = $("#listado_empleados").html();
var arr_empleados = empleados_html.split(",");
function submit_adicionales() {
	$("table").find(".error_documento").html("");
	$("table").find(".error_encontrado_sibc").html("");
	$("table").find(".error_nombre_ced_sibc").html("");
	$("table").find(".error_id_contrato_sibc").html("");
	var error = 0;
	$(".num_documento[disabled!='disabled']").each(function() {
		var tr = $(this).parent();
    	var encontrados = 0;
    	var num_documento = $(this).val();
    	if(jQuery.inArray(num_documento, arr_empleados) > -1){
    		tr.find(".error_documento").html("<ul class='parsley-error-list'><li class='required' style='display: list-item;'>Esta cédula se encuentra en el listado de asistencia de talento humano.</li></ul>");
    		error = 1;
    	};
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
