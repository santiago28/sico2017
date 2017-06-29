
{{ content() }}
<h1>Contratos</h1>
<table class="table table-bordered table-hover">
	<thead>
    	 <tr>
            <th>Número contrato</th>
            <th>Modalidad</th>
         </tr>
    </thead>
    <tbody>
    {% for contrato in contratos %}
        <tr>
            <td>{{ link_to("bc_reporte/oferente_periodos/"~contrato.id_contrato, contrato.id_contrato) }}</td>
            <td>{{ link_to("bc_reporte/oferente_periodos/"~contrato.id_contrato, contrato.modalidad_nombre) }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>