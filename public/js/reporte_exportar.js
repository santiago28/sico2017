var nombre_reporte = $("#nombre_reporte").html();
$("#exportar").click (
	function(){
		$("#reporte").table2excel({
		    name: "test.xlsx"
		});
	}
);
