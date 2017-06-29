$(".cancelar_fecha").click (
    function(){
    	var nombre = $(this).attr("data-nombre_cancelar");
    	var fecha = $(this).attr("data-fecha_cancelar");
      var id = $(this).attr("data-id");
    	$(".nombre_cancelar").html(nombre);
    	$(".fecha_cancelar").html(fecha);
      $(".id_elemento").val(id);
    }
);
$(".crear_fecha").click (
    function(){
    	var fecha = $(this).attr("data-fecha_crear");
      var fechaf = $(this).attr("data-fechaf_crear");
    	$(".fecha_crear").html(fecha);
      $(".fechaf_crear").val(fechaf);
    }
);
