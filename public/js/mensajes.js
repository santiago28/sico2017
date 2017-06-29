//<![CDATA[
$(document).ready(function() {
  $('.filter').multifilter()
})
//]]>
$('#destinatario').change(function() {
	var destinatario = $(this).val();
	if(destinatario == 4){
		$('#agregar_usuarios').modal('show');
	}
});
$('#destinatario').click(function() {
	var destinatario = $(this).val();
	if(destinatario == 4){
		$('#agregar_usuarios').modal('show');
	}
});
var usuarios_checkeados = [];
$(".usuario_check").click (
	function(){
		usuarios_checkeados.push($(this).val());
	}
);
$("#btn_agregar").click(function() {
	$("#cont-users").html("");
	for ( var i in usuarios_checkeados ) {
		$("#cont-users").append("<span class='label label-primary pull-right'>"+ $("#lista_usuarios #"+usuarios_checkeados[ i ]).attr("data-usuario")+"<i class='glyphicon glyphicon-remove'></i><input type='hidden' class='usuarios_agregados' name='usuarios_agregados[]' value='"+$("#lista_usuarios #"+usuarios_checkeados[ i ]).val()+"'></span>");
	}
	$("#cont-users .glyphicon-remove").click(function() {
		var input = $(this).parent().find("input").val();
		$("#lista_usuarios td #"+input).attr('checked', false);
		$(this).parent().remove();
	});
});
