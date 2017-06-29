$('.sinonare').change(function() {
	var val = $(this).val();
	if(val == 3 || val == 4){
		$(this).parent().parent().find(".sinonare").val(val);
	}
});
