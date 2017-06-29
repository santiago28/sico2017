$( '#permiso_general_form' ).parsley( 'destroy' );
$( '#permiso_general_form' ).parsley();
reasignar_keys();
$(".eliminar_guardado").click (
	function(){
		eliminar_guardado($(this));
});
$('#pegar_listado').on('input',function(e){
	var data = $(this).val();
	var rows = data.split("\n");
	if(rows.length > 500){
		$(".alerta_lote").html("<div class='alert alert-danger'><i class='glyphicon glyphicon-warning-sign'></i> Sólamente puedes guardar un máximo de 500 niños.</div>");
		$("#pegar_listado").val("");
		$(".alerta_lote").fadeOut();
    $(".alerta_lote").fadeIn();
	} else {
		for(var y in rows) {
	    var cells = rows[y].split("\t");
			if(cells[0]){
				$('#listado_participantes_lista tbody tr:hidden:first').find(".nombreCompleto").val(cells[0]);
				$('#listado_participantes_lista tbody tr:hidden:first').find(".numDocumento").val(cells[1]);
				$('#listado_participantes_lista tbody tr:hidden:first').find("input").removeAttr("disabled");
				$('#listado_participantes_lista tbody tr:hidden:first').removeAttr("style");
			}
		}
		$( '#permiso_general_form' ).parsley( 'destroy' );
		$( '#permiso_general_form' ).parsley();
		reasignar_keys();
		$("#pegar_listado").val("");
	}
})
$("#limpiar_formulario").click (
    function() {
      $( '.limpiar' ).find("input").attr("disabled", "disabled");
      $( '.limpiar' ).find("input").val("");
      $( '.limpiar' ).find("input").parent().parent().hide();
      $( '#permiso_general_form' ).parsley( 'destroy' );
    	$( '#permiso_general_form' ).parsley();
    	reasignar_keys();
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

$(document).ready(function(){
	$(".eliminar_valor").click(
        function(){
        	eliminar_valor($(this));
        }
    );
		$('#paso1').tooltipster({
								position: 'bottom',
                content: $('<span><img src="/sico/img/permisos/1.png" /></span>')
    });
		$('#paso2').tooltipster({
								position: 'bottom',
                content: $('<span><img src="/sico/img/permisos/2.png" /></span>')
    });
});
function reasignar_keys(){
	var i = 1;
	$(".numDocumento[disabled!='disabled']").each(function() {
    	$(this).parent().parent().find(".number").html(i);
    	i++;
	});
}
function agregar_item(valor) {
	var n_filas = $( ".numDocumento[disabled!='disabled']" ).size();
	if(n_filas < 500){
		$('#listado_participantes_lista tbody tr:hidden:first').find("input").removeAttr("disabled");
		$('#listado_participantes_lista tbody tr:hidden:first').removeAttr("style");
		$( '#permiso_general_form' ).parsley( 'destroy' );
		$( '#permiso_general_form' ).parsley();
		reasignar_keys();
	} else {
		$(".alerta_lote").html("<div class='alert alert-danger'><i class='glyphicon glyphicon-warning-sign'></i> Sólamente puedes guardar un máximo de 500 niños.</div>");
		$(".alerta_lote").fadeOut();
    $(".alerta_lote").fadeIn();
	}
}
function eliminar_valor(valor){
	$(valor).parent().parent().find("input").attr("disabled", "disabled");
  $(valor).parent().parent().hide();
  $( '#permiso_general_form' ).parsley( 'destroy' );
	$( '#permiso_general_form' ).parsley();
	reasignar_keys();
}
$('.submit_listado').click(function() {
	submit_listado();
});
function submit_listado() {
	$("#listado_participantes_lista").find(".error_documento").html("");
	$("#listado_participantes_lista").find(".error_nombre").html("");
	$(".error_nopersonas").html("");
	var error = 0;
	if(!$(".nombreCompleto").val()){
		error = 1;
		$(".error_nopersonas").html("<ul class='parsley-error-list'><li class='required' style='display: list-item;'>Debes de ingresar al menos un beneficiario.</li></ul>");
	}
  $(".nombreCompleto[disabled!='disabled']").each(function() {
    var tr = $(this).parent();
    var nombreCompleto = $(this).val();
    if(!nombreCompleto){
      error = 1;
      tr.find(".error_nombre").html("<ul class='parsley-error-list'><li class='required' style='display: list-item;'>Este campo es obligatorio.</li></ul>");
    }
  });
	$(".numDocumento[disabled!='disabled']").each(function() {
		var tr = $(this).parent();
    	var encontrados = 0;
    	var numDocumento = $(this).val();
      if(!numDocumento){
        error = 1;
        tr.find(".error_documento").html("<ul class='parsley-error-list'><li class='required' style='display: list-item;'>Este campo es obligatorio.</li></ul>");
      }
    	$(".numDocumento[disabled!='disabled']").each(function() {
        	var numDocumento2 = $(this).val();
        	if(numDocumento == numDocumento2){
				encontrados = encontrados + 1;
        	}
        });
    	if(encontrados > 1){
				tr.find(".error_documento").html("<ul class='parsley-error-list'><li class='required' style='display: list-item;'>Este campo se encuentra duplicado.</li></ul>");
				error = 1;
    	}
    });
	if(error == 0){
		$("#permiso_general_form").submit();
	}
}
