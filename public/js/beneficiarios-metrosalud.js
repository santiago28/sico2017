$('.asistencia').change(function() {
	var asistencia = $(this).val();
	if(asistencia == 6 || asistencia == 5 || asistencia == 4){
		$(this).parent().parent().find(".ciclovital").val(0);
		$(this).parent().parent().find(".alimentario").val(3);
	}
});
