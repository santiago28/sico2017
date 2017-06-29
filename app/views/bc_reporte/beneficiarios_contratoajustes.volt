
{{ content() }}
<h1>Ajustes para el periodo {{ periodo.getFechaAnioDetail() }} <br><small>CONTRATO {{ contrato.id_contrato }} MODALIDAD {{ contrato.modalidad_nombre }}</small></h1>
{{ link_to("bc_reporte/oferente_periodos/"~contrato.id_contrato, '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
<table id='reporte' class="table table-bordered table-hover">
	<thead>
    	 <tr>
            <th>Fecha reporte de Ajustes</th>
         </tr>
    </thead>
    <tbody>
    {% for ajuste in ajustes %}
        <tr>
        	<td>{{ link_to("cob_ajuste/reportebeneficiarioscontrato/"~ajuste.fecha_ajuste_reportado~"/"~periodo.id_periodo~"/"~contrato.id_contrato, ajuste.fecha_ajuste_reportado) }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>