
{{ content() }}
<h1>Periodos <br><small>CONTRATO {{ contrato.id_contrato }} MODALIDAD {{ contrato.modalidad_nombre }}</small></h1>
{{ link_to("bc_reporte/oferente_contratos", '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
<table class="table table-bordered table-hover">
	<thead>
    	 <tr>
            <th>Periodo</th>
            <th>Reporte Niño a Niño R1 y R2</th>
            <th>Reporte Niño a Niño todos los Recorridos</th>
            <th>Reporte Niño a Niño de Facturación</th>
            <th>Reporte Niño a Niño de Ajustes</th>
         </tr>
    </thead>
    <tbody>
    {% for periodo in periodos %}
        <tr>
            <td>{{ periodo.CobPeriodo.getFechaDetail() }}</td>
            <td>{{ link_to("bc_reporte/beneficiarios_contratoparcial/"~periodo.id_periodo~"/"~contrato.id_contrato, '<i class="glyphicon glyphicon-file"></i> ', "rel": "tooltip", "title":"Reporte R1 y R2") }}</td>
            <td>{{ link_to("bc_reporte/beneficiarios_contratofinal/"~periodo.id_periodo~"/"~contrato.id_contrato, '<i class="glyphicon glyphicon-file"></i> ', "rel": "tooltip", "title":"Reporte Recorridos") }}</td>
            <td>{{ link_to("bc_reporte/beneficiarios_contratofacturacion/"~periodo.id_periodo~"/"~contrato.id_contrato, '<i class="glyphicon glyphicon-file"></i> ', "rel": "tooltip", "title":"Reporte Facturación") }}</td>
            <td>{{ link_to("bc_reporte/beneficiarios_contratoajustes/"~periodo.id_periodo~"/"~contrato.id_contrato, '<i class="glyphicon glyphicon-file"></i> ', "rel": "tooltip", "title":"Reporte Ajustes") }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>