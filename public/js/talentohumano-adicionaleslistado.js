$('.sinonare').change(function() {
	sinonare($(this));
});
function sinonare(input){
	var val = $(input).val();
	if(val == 3 || val == 4){
		$(input).parent().parent().find(".sinonare").val(val);
		$(input).parent().parent().find(".observacion").removeClass("required");
		$( '#talentohumano_form' ).parsley( 'destroy' );
		$( '#talentohumano_form' ).parsley();
	} else if(val == 2){
		$(input).parent().parent().find(".observacion").addClass("required");
		$( '#talentohumano_form' ).parsley( 'destroy' );
		$( '#talentohumano_form' ).parsley();
	} else if(val == 1){
		var encontrado = 0;
		$(input).parent().parent().find('.sinonare').each(function(){
			if($(input).val() == 2){
				encontrado = 1;
			}
		});
		if(encontrado == 0){
			$(input).parent().parent().find(".observacion").removeClass("required");
			$( '#talentohumano_form' ).parsley( 'destroy' );
			$( '#talentohumano_form' ).parsley();
		}
	}
}
$('.agregar_cedula').click(function() {
	agregar_cedula();
});
$('.input_agregar_ced').bind("enterKey",function(e){
	agregar_cedula();
	});
	$('.input_agregar_ced').keyup(function(e){
	if(e.keyCode == 13)
	{
	  $(this).trigger("enterKey");
	}
});
function agregar_cedula(){
	$(".error").html("");
	var cedula = "#" + $(".input_agregar_ced").val();
	var fila = $("#talentohumano_lista " + cedula).html();
	var fila_repetida = $("#adicionales_listado " + cedula).html();
	if(fila_repetida != undefined){
		$(".error").append("<ul class='parsley-error-list'><li class='required' style='display: list-item;'>Esta cédula ya fue agregada en este listado.</li></ul>");
		$(".error").fadeOut();
		$(".error").fadeIn();
		$(".error").fadeOut();
		$(".error").fadeIn();
		$(".error").fadeOut();
		$(".error").fadeIn();
		$(".error").fadeOut();
		$(".error").fadeIn();
		return;
	}
	if(fila == undefined){
		$(".error").append("<ul class='parsley-error-list'><li class='required' style='display: list-item;'>Esta cédula no fue encontrada en los listados generales.</li></ul>");
		$(".error").fadeOut();
		$(".error").fadeIn();
		$(".error").fadeOut();
		$(".error").fadeIn();
		$(".error").fadeOut();
		$(".error").fadeIn();
		$(".error").fadeOut();
		$(".error").fadeIn();
		return;
	}
	$("#adicionales_listado").append("<tr id='"+ $(".input_agregar_ced").val() +"'>"+fila+"</tr>");
	$( '#adicionales_form' ).parsley( 'destroy' );
	$( '#adicionales_form' ).parsley();
	$('.sinonare').change(function() {
		sinonare($(this));
	});
}
