$('.sinonare').change(function() {
	var val = $(this).val();
	if(val == 3 || val == 4){
		$(this).parent().parent().find(".sinonare").val(val);
		$(this).parent().parent().find(".observacion").removeClass("required");
		$( '#talentohumano_form' ).parsley( 'destroy' );
		$( '#talentohumano_form' ).parsley();
	} else if(val == 2){
		$(this).parent().parent().find(".observacion").addClass("required");
		$( '#talentohumano_form' ).parsley( 'destroy' );
		$( '#talentohumano_form' ).parsley();
	} else if(val == 1){
		var encontrado = 0;
		$(this).parent().parent().find('.sinonare').each(function(){
			if($(this).val() == 2){
				encontrado = 1;
			}
		});
		if(encontrado == 0){
			$(this).parent().parent().find(".observacion").removeClass("required");
			$( '#talentohumano_form' ).parsley( 'destroy' );
			$( '#talentohumano_form' ).parsley();
		}
	}
});
