$(".confirmar_ajuste").click(function() {
	if($( '#ajuste' ).parsley( 'validate' )){
		$('#confirmacion_ajuste').modal('show');
	}
});