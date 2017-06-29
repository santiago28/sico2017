$('#id_usuario_cargo').change(function() {
	var cargo = $(this).val();
	if(cargo == 3){
		$("#id_usuario_lider").parent().parent().removeClass("hide");
		$("#id_usuario_lider").removeAttr("disabled");
		$("#id_usuario_lider").addClass("required");
	} else {
		$("#id_usuario_lider").parent().parent().addClass("hide");
		$("#id_usuario_lider").attr("disabled", "disabled");
		$("#id_usuario_lider").removeClass("required");
	}
	$( '#nuevo_form' ).parsley( 'destroy' );
	$( '#nuevo_form' ).parsley();
});
if($("#id_usuario_cargo").val() == 3){
	$("#id_usuario_lider").parent().parent().removeClass("hide");
	$("#id_usuario_lider").removeAttr("disabled");
	$("#id_usuario_lider").addClass("required");
} else {
	$("#id_usuario_lider").parent().parent().addClass("hide");
	$("#id_usuario_lider").attr("disabled", "disabled");
	$("#id_usuario_lider").removeClass("required");
}
$('.image-editor').cropit();

var background =  "url("+$('#foto').val()+")";
$('.cropit-image-preview').css("background-image", background);
$('.submit').click(function() {
	if($( 'form' ).parsley( 'validate' )){
	  var imageData = $('.image-editor').cropit('export');
	  $('.hidden-image-data').val(imageData);
	  // Print HTTP request params
	  var formValue = $(this).serialize();
	  $('#result-data').text(formValue);
	  $('form').submit();
	}
});