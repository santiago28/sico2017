$( '#adicionales_form' ).parsley( 'destroy' );
$( '#adicionales_form' ).parsley();
reasignar_keys();
$('#duplicar_fecha').click(function() {
	var fecha = $( ".fecha" ).first().val();
	$('.fecha').each(function() {
    	$(this).val(fecha);
    });
});
$(".eliminar_guardado").click (
	function(){
		eliminar_guardado($(this));        	
});
$("#btn_varios_items").click (
	function() {
		var n_filas = $( ".num_documento[disabled!='disabled']" ).size();
    	if(n_filas >= 50){
	    	$(".alerta_lote").html("<i class='glyphicon glyphicon-warning-sign'></i> Sólo puedes guardar hasta 50 empleados.");
	    	$(".alerta_lote").fadeOut();
	    	$(".alerta_lote").fadeIn();
	    	return;
    	} else {
        	var x2 = 50 - n_filas;
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
	if(n_filas !== 50){
		$('#adicionales_form tbody tr:hidden:first').find("input").removeAttr("disabled");
		$('#adicionales_form tbody tr:hidden:first').find("select").removeAttr("disabled");
		$('#adicionales_form tbody tr:hidden:first').find("textarea").removeAttr("disabled");
		$('#adicionales_form tbody tr:hidden:first').removeAttr("style");
		$( '#adicionales_form' ).parsley( 'destroy' );
		$( '#adicionales_form' ).parsley();
		reasignar_keys();
	} else {
		$(".alerta_lote").html("<i class='glyphicon glyphicon-warning-sign'></i> Sólo puedes agregar hasta 50 empleados.");
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
function submit_adicionales() {
	$("table").find(".error_documento").html("");
	var error = 0;
	$(".num_documento[disabled!='disabled']").each(function() {
		var tr = $(this).parent();
    	var encontrados = 0;
    	var num_documento = $(this).val();
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