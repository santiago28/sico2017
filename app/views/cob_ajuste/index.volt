
{{ content() }}
<h1>Ajustes</h1>
{{ link_to("cob_ajuste/buscar", '<i class="glyphicon glyphicon-plus"></i> Nuevo ajuste', "class": "btn btn-primary menu-tab") }}
{{ link_to("cob_ajuste/nuevafechareporte", '<i class="glyphicon glyphicon-plus"></i> Fechas de reporte', "class": "btn btn-primary menu-tab") }}
{{ link_to("cob_ajuste/asignar", '<i class="glyphicon glyphicon-calendar"></i> Asignar ajustes a fecha', "class": "btn btn-primary menu-tab") }}
{{ link_to("cob_ajuste/asignarperiodos", '<i class="glyphicon glyphicon-list-alt"></i> Asignar ajustes a periodo', "class": "btn btn-primary menu-tab") }}
{{ link_to("cob_ajuste/reportes", '<i class="glyphicon glyphicon-list-alt"></i> Reportes', "class": "btn btn-primary menu-tab") }}
{% if (not(cob_ajuste_noasignados is empty)) %}
<table class="table table-bordered table-hover">
	<thead>
        <tr>
            <th style="text-align: center;">Ajustes No Asignados</th>
         </tr>
    </thead>
    <tbody>
    	<tr><td>
			{{ link_to("cob_ajuste/noasignados/", "Total no asignados", "class": "btn btn-primary btn-lg btn-block") }}
    	</td></tr>
    </tbody>
</table>
{% endif %}
{% if (not(cob_ajuste_reporte is empty)) %}
<table class="table table-bordered table-hover">
	<thead>
        <tr>
            <th style="text-align: center;">Ajustes fuera del periodo</th>
         </tr>
    </thead>
    <tbody>
    	<tr><td>
	    {% for cob_ajuste_reporte in cob_ajuste_reporte %}
			{{ link_to("cob_ajuste/reporte/"~cob_ajuste_reporte.fecha_ajuste_reportado, this.conversiones.fecha(3, cob_ajuste_reporte.fecha_ajuste_reportado), "class": "btn btn-primary btn-lg btn-block") }}
	    {% endfor %}
    	</td></tr>
    </tbody>
</table>
{% endif %}
{% if (not(cob_ajuste_periodo is empty)) %}
<table class="table table-bordered table-hover">
	<thead>
        <tr>
            <th style="text-align: center;">Ajustes dentro del periodo</th>
         </tr>
    </thead>
    <tbody>
    	<tr><td>
	    {% for cob_ajuste_periodo in cob_ajuste_periodo %}
			{{ link_to("cob_ajuste/periodo/"~cob_ajuste_periodo.id_periodo, cob_ajuste_periodo.CobPeriodo.getFechaDetail() ~" - " ~ cob_ajuste_periodo.CobPeriodo.getTipoperiodoDetail(), "class": "btn btn-primary btn-lg btn-block") }}
	    {% endfor %}
    	</td></tr>
    </tbody>
</table>
{% endif %}
