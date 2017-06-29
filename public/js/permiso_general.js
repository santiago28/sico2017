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
				$('#listado_participantes_tabla tbody tr:hidden:first').find(".nombreCompleto").val(cells[0]);
				$('#listado_participantes_tabla tbody tr:hidden:first').find(".numDocumento").val(cells[1]);
				$('#listado_participantes_tabla tbody tr:hidden:first').find("input").removeAttr("disabled");
				$('#listado_participantes_tabla tbody tr:hidden:first').removeAttr("style");
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
      $( '#listado_participantes_tabla' ).find("input").attr("disabled", "disabled");
      $( '#listado_participantes_tabla' ).find("input").val("");
      $( '#listado_participantes_tabla tbody tr' ).hide();
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
		$('#listado_participantes_tabla tbody tr:hidden:first').find("input").removeAttr("disabled");
		$('#listado_participantes_tabla tbody tr:hidden:first').removeAttr("style");
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
	$("#listado_participantes_tabla").find(".error_documento").html("");
	var error = 0;
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
    $('#modal_participantes').modal('hide');
    $('#num_participantes').html($( ".numDocumento[disabled!='disabled']" ).size());
	}
}
var tipo;
$("select#tipo_permiso").change(function(){
    var select = $("select#tipo_permiso").val();
    if(select == 0){
        $('#fecha').parent().parent().fadeIn();
        $('#fecha').removeAttr("disabled");
        $('#fecha_inicio_permiso').parent().parent().fadeOut();
        $('#fecha_fin_permiso').parent().parent().fadeOut();
        $('#fecha_inicio_permiso').attr("disabled", "disabled");
        $('#fecha_fin_permiso').attr("disabled", "disabled");
        $('.dias_permiso').parent().fadeOut();
        $('.dia').attr("disabled", "disabled");
    } else {
    	$('#fecha').parent().parent().fadeOut();
    	$('#fecha').attr("disabled", "disabled");
        $('#fecha_inicio_permiso').parent().parent().fadeIn();
        $('#fecha_inicio_permiso').removeAttr("disabled");
        $('#fecha_fin_permiso').parent().parent().fadeIn();
        $('#fecha_fin_permiso').removeAttr("disabled");
        $('.dias_permiso').parent().fadeIn();
        $('.dia').removeAttr("disabled");
    }
});
$(".transporte").hide();
$(".requiere_transporte").click (
		function(){
			$('.transporte').find("input").removeAttr("disabled");
			$('.transporte').show();
})
$(".no_requiere_transporte").click (
		function(){
			$('.transporte').find("input").attr("disabled", "disabled");
			$('.transporte').hide();
})
var festivos = $("#festivos").html().split(',');
$('#permiso_general_form .tipo-fecha').datepicker({
    format: "dd/mm/yyyy",
    datesDisabled: festivos,
    weekStart: 0,
    autoclose: true,
    startDate: $('#fecha_inicio').val(),
    endDate: $('#fecha_fin').val(),
    language: "es"
    //daysOfWeekDisabled: "0,6"
});
//initialize input widgets first
$('.hora input').timepicker({
    'showDuration': true,
    'timeFormat': 'g:iA',
    'minTime': '8:00am',
    'maxTime': '6:00pm',
    'step': 15
});

// initialize datepair
$('form').datepair();

$(".fileupload").change(function() {
	var archivo = $(this);
	tipo =  $(archivo).attr("data-tipo");
	var url = window.location.protocol + "//" + window.location.host + "/sico/" + "bc_permiso/subir_archivo/" + $("table").attr("id") + "/" + tipo;
	$(archivo).parent().find('#progress .progress-bar').css(
            "width", "0"
        );
	$(archivo).parent().find('.captura').remove();
	var formData = new FormData();
	formData.append( 'file', $(archivo).get(0).files[0] );
	    $.ajax( {
	      url: url,
	      type: 'POST',
	      data: formData,
	      processData: false,
	      contentType: false,
	      success: function (data) {
	    	  if(data == "imgpdf"){
	    		  alert("Error: El tipo de archivo debe de ser jpg, png, bmp, gif o pdf")
	    	  } else if(data == "xls"){
	    		  alert("Error: El tipo de archivo debe de ser xls o xlsx (archivo de Excel)")
	    	  } else if(data == "Error"){
	    		  alert("Ocurrió un error la subir la imagen");
	    	  } else {
	    		  $(archivo).parent().find('#progress .progress-bar').css(
  	                "width", "100%"
  	              );
	    		  $(archivo).parent().append("<a class='captura' target='_blank' href='" + window.location.protocol + "//" + window.location.host + "/sico/files/permisos/" + data + "'>Clic para ver</a>");
  				  $(archivo).parent().find(".urlArchivo").val(data);
  		        }
	    	  }
	    });
});
