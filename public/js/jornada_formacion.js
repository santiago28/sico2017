$('#jornada_formacion_form' ).parsley( 'destroy' );
$('#jornada_formacion_form' ).parsley();
$("#btn_varios_items").click (
	function() {
		var n_filas = $( ".tipo-fecha[disabled!='disabled']" ).size();
		var permisos_anuales = $(".permisos_anuales").html();
    	if(n_filas >= permisos_anuales){
	    	$(".alerta_lote").html("<i class='glyphicon glyphicon-warning-sign'></i> Sólo puedes guardar hasta "+ permisos_anuales+ " 24 jornadas de planeación en una misma sede en todo el año.");
	    	$(".alerta_lote").fadeOut();
	    	$(".alerta_lote").fadeIn();
	    	return;
    	} else {
        	var x2 = permisos_anuales - n_filas;
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
function agregar_item(valor) {
	var n_filas = $( ".tipo-fecha[disabled!='disabled']" ).size();
	if(n_filas !== 24){
		$('#jornada_formacion_form tbody tr:hidden:first').find("input").removeAttr("disabled");
		$('#jornada_formacion_form tbody tr:hidden:first').removeAttr("style");
		$('#jornada_formacion_form' ).parsley( 'destroy' );
		$('#jornada_formacion_form' ).parsley();
		reasignar_keys();
	} else {
		$(".alerta_lote").html("<i class='glyphicon glyphicon-warning-sign'></i> Sólo puedes guardar hasta 24 permisos de planeación por sede en todo el año.");
		$(".alerta_lote").fadeOut();
    	$(".alerta_lote").fadeIn();
	}
}
function reasignar_keys(){
	var i = 1;
	$(".tipo-fecha[disabled!='disabled']").each(function() {
    	$(this).parent().parent().find(".number").html(i);
    	i++;
	});
}
function eliminar_valor(valor){
	$(valor).parent().parent().remove();
	$("#jornada_formacion_form tbody tr:hidden:first" ).clone().appendTo( "tbody" );
    $('#jornada_formacion_form' ).parsley( 'destroy' );
	$('#jornada_formacion_form' ).parsley();
	reasignar_keys();
}
var festivos = $("#festivos").html().split(',');
$('#jornada_formacion_form .tipo-fecha').datepicker({
    format: "dd/mm/yyyy",
    datesDisabled: festivos,
    weekStart: 0,
    startDate: $('#fecha_inicio').val(),
    endDate: $('#fecha_fin').val(),
    language: "es"
    //daysOfWeekDisabled: "0,6"
});

//initialize input widgets first
$('tr .time').timepicker({
    'showDuration': true,
    'timeFormat': 'g:iA',
    'minTime': '8:00am',
    'maxTime': '6:00pm',
    'step': 15
});

// initialize datepair
$('tr').datepair();