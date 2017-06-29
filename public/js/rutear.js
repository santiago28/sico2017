$("#ruteo").tablesorter({sortList: [[0,0]], headers: { 1:{sorter: false}, 2:{sorter: true}, 3:{sorter: true}, 4:{sorter: true}, 5:{sorter: true}, 6:{sorter: true}, 7:{sorter: true}, 8:{sorter: true}, 9:{sorter: true}}});
var actas_checkeadas = [];
$('.periodo_select').click(function() {
	var id_periodo = $(this).parent().parent().find(".id_periodo").attr('id');
	var recorrido = $(this).parent().parent().find(".recorrido").attr('id');
	$(".ruteo_id_periodo").val(id_periodo);
	$(".ruteo_recorrido").val(recorrido);
	document.ruteodesdeotro.submit();
});
$('.verificacion_select').click(function() {
	var id_verificacion = $(this).parent().parent().find(".id_verificacion").attr('id');
	$(".ruteo_id_verificacion").val(id_verificacion);
	document.ruteodesdeotroverificacion.submit();
});
$(".acta_check").click (
	function(){
		actas_checkeadas.push($(this).val());
		var checked = $('input:checkbox:checked').length;
        $("#num_check").html(checked);
        if(checked > 0){
    		$("#asignar_contador").removeClass( "disabled" );
    	}
        else {
        	$("#asignar_contador").addClass( "disabled" );
        }
	}
);

$(".uncheck").click (
		function(){
			$('input:checkbox').attr('checked', false);
			actas_checkeadas = [];
			$("#num_check").html("0");
		}
	);
$(".quitar_select").click (
	function(){
		$('#ruteo').find(".asignando").parent().parent().find(".no_asignado").html("No asignado");
		$('#ruteo').find(".asignando").parent().parent().find(".contador_asignado").val("");
		$('#ruteo').find(".asignando").parent().parent().removeClass("warning");
		$('#ruteo').find(".asignando").parent().parent().find(".id_acta").attr("disabled", "disabled");
		$('#ruteo').find(".asignando").parent().parent().find(".contador_asignado").attr("disabled", "disabled");
		$('#ruteo').find(".asignando").parent().parent().find(".no_asignado").removeClass("asignando");
		$('input:checkbox').attr('checked', false);
		actas_checkeadas = [];
		$("#num_check").html("0");
	}
);
$("#asignar_contador").click (
		function(){
			var contador = $("#contador").val();
			var contador_nombre = $("#contador option:selected").text();
			console.log(actas_checkeadas);
			for ( var i in actas_checkeadas ) {
    				if(contador == "NULL" || contador == ""){
        				$("#ruteo #"+actas_checkeadas[i]).parent().parent().find(".interventor span").html("Inhabilitar");
        		} else {
            			$("#ruteo #"+actas_checkeadas[i]).parent().parent().find(".interventor span").html(contador_nombre);
            }
    				 $("#ruteo #"+actas_checkeadas[i]).parent().parent().find(".contador_asignado").val(contador);
    				 $("#ruteo #"+actas_checkeadas[i]).parent().parent().find(".contador_asignado").removeAttr('disabled');
    				 $("#ruteo #"+actas_checkeadas[i]).parent().parent().addClass("warning");
    				 $("#ruteo #"+actas_checkeadas[i]).parent().parent().find(".id_acta").removeAttr('disabled');
    				 $("#ruteo #"+actas_checkeadas[i]).parent().parent().find(".no_asignado").addClass('asignando');
    				 $("#ruteo #"+actas_checkeadas[i]).parent().parent().find(".asignado").addClass('asignando');
			}
			$(".quitar_select").removeAttr("disabled");
			$(".guardar_ruteo").removeAttr("disabled");
			$('input:checkbox').attr('checked', false);
			actas_checkeadas = [];
		}
	);
//Para filtrar las actas ruteadas o no ruteadas
$("select#descripcion_permiso").change(function(){
    var estado_select = $("select#descripcion_permiso").val();
    if(estado_select == "no_repetir"){
        $('#fecha_permiso').parent().parent().fadeIn();
    }
    else if (estado_select == "asignadas") {
        $('table tbody tr').fadeOut();
        $(".asignado").parent().parent().fadeIn();
    }
    else if (estado_select == "no_asignadas") {
        $('table tbody tr').fadeOut();
        $(".no_asignado").parent().parent().fadeIn();
    }
});
$(document).ready(function(){
	$(".actas_ruteadas").html($(".asignado").length);
	$(".actas_por_rutear").html($(".no_asignado").length);
});
