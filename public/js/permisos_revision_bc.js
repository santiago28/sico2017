var checked;
$(".permiso_check").click (
	function(){
		//permisos_seleccionados.push($(this).val());
		checked = $('input:checkbox:checked').length;
		$(this).parent().parent().toggleClass("warning");
		$("#num_check").html(checked);
	}
);
$("#btn_lote_salidas").click (
	function(){
		$(".lote_salidas").removeAttr("disabled");
		$(".lote_salidas").fadeIn();
		$(".lote_jornadas").attr("disabled", "disabled");
		$(".lote_jornadas").fadeOut();
	}
);
$("#btn_lote_jornadas").click (
	function(){
		$(".lote_jornadas").removeAttr("disabled");
		$(".lote_jornadas").fadeIn();
		$(".lote_salidas").attr("disabled", "disabled");
		$(".lote_salidas").fadeOut();
	}
);
$(".checkall").click (
		function(){
			$('input:checkbox:visible').prop('checked', true);
			$( '.permiso_check:visible' ).parent().parent().addClass( "warning" );
			checked = $('input:checkbox:checked').length;
			$("#num_check").html(checked);
		}
	);
$(".uncheck").click (
		function(){
			$('input:checkbox:visible').prop('checked', false);
			checked = $('input:checkbox:checked').length;
			$("#num_check").html(checked);
			$( '.permiso_check:visible' ).parent().parent().removeClass( "warning" );
		}
	);

$("select#estado_bc").change(function(){
    var estado_select = $("select#estado_bc").val();
    if(estado_select == 4){
        $('.campo_motivo_anular').fadeIn();
        $(".campo_motivo_anular input").removeAttr("disabled");
				$('.campo_motivo_aprobar').fadeOut();
				$(".campo_motivo_aprobar input").attr("disabled", "disabled");
    }
    else if(estado_select == 2) {
    	$('.campo_motivo_aprobar').fadeIn();
      $(".lote_salidas").removeAttr("disabled");
			$('.campo_motivo_anular').fadeOut();
			$(".campo_motivo_anular input").attr("disabled", "disabled");

    } else {
    	$('.campo_motivo').fadeOut();
    	$(".campo_motivo input").attr("disabled", "disabled");
    }
});
$('.submit').click(function() {
	submit();
});
function submit() {
	var estado_select = $("select#estado_bc").val();
	var error = 0;
	var num_check = $("#num_check").html();
	if(num_check == "0"){
		$(".error_permisos").html("<ul class='parsley-error-list'><li class='required' style='display: list-item;'>Debes de seleccionar al menos un permiso.</li></ul>");
		$(".error_permisos").fadeIn();
		$(".error_permisos").fadeOut();
		$(".error_permisos").fadeIn();
		$(".error_permisos").fadeOut();
		$(".error_permisos").fadeIn();
		$(".error_permisos").fadeOut();
		$(".error_permisos").fadeIn();
		$(".error_permisos").fadeOut();
		$(".error_permisos").fadeIn();
		error = 1;
	}
	if(estado_select == "0"){
		$(".error_permisos").html("<ul class='parsley-error-list'><li class='required' style='display: list-item;'>Debes de seleccionar el estado por el cual deseas cambiar los permisos.</li></ul>");
		$(".error_permisos").fadeIn();
		$(".error_permisos").fadeOut();
		$(".error_permisos").fadeIn();
		$(".error_permisos").fadeOut();
		$(".error_permisos").fadeIn();
		$(".error_permisos").fadeOut();
		$(".error_permisos").fadeIn();
		$(".error_permisos").fadeOut();
		$(".error_permisos").fadeIn();
		error = 1;
	}
	if(error == 0){
		if($( '#agregar_permisos' ).parsley( 'validate' )){
			$('#agregar_permisos').submit();
		}
	}
}
