$("#btn_salidas").click (
	function(){
		$(".salidas").removeAttr("disabled");
		$(".salidas").fadeIn();
		$(".jornadas").attr("disabled", "disabled");
		$(".jornadas").fadeOut();
	}
);
$("#btn_jornadas").click (
	function(){
		$(".jornadas").removeAttr("disabled");
		$(".jornadas").fadeIn();
		$(".salidas").attr("disabled", "disabled");
		$(".salidas").fadeOut();
	}
);
var options1 = { clearFiltersControls: [$('#cleanfilters')] };
$('#permisos_lista').tableFilter(options1);
$(".buscar-permiso-btn").click (
		function(){
			var url = window.location.protocol + "//" + window.location.host + "/sico/" + "bc_permiso/permiso/" + $(".buscar-permiso-input").val();
			window.location.replace(url);
})
