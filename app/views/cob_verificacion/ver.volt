
{{ content() }}
<h1>Verificación {{ verificacion.nombre }}</h1>
{{ link_to("cob_verificacion", '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
{% if (nivel <= 2) %}
{{ link_to("cob_verificacion/rutear/"~id_verificacion, '<i class="glyphicon glyphicon-road"></i> Rutear', "class": "btn btn-primary menu-tab") }}
{% endif %}
{{ link_to("cob_verificacion/gdocumental/"~id_verificacion, '<i class="glyphicon glyphicon-file"></i> Gestión Documental', "class": "btn btn-primary menu-tab") }}
<table class="table table-bordered table-hover filtrar" id="recorrido">
    <thead>
        <tr><th>#</th>
            <th>No. Acta</th>
            <th>No. Contrato</th>
            <th>Prestador</th>
            <th>Sede</th>
            <th>Modalidad</th>
            <th>Interventor</th>
            <th>Estado</th>
         </tr>
    </thead>
    <tbody>
    {% for acta in actas %}
    	{% if (nivel <= 1 or (acta.id_usuario == id_usuario or acta.IbcUsuario.id_usuario_lider == id_usuario)) %}
        <tr>
        	<td>{{ loop.index }}</td>
            <td>{{ link_to(acta.getUrlDetail(), acta.getIdDetail()) }}</td>
            <td>{{ acta.id_contrato }}</td>
            <td>{{ acta.oferente_nombre }}</td>
            <td>{{ acta.id_sede }} - {{ acta.sede_nombre }}</td>
            <td>{{ acta.modalidad_nombre }}</td>
            <td>{{ acta.IbcUsuario.usuario }}</td>
            <td>{{ acta.getEstadoDetail() }}</td>            
        </tr>
        {% endif %}
    {% endfor %}
    </tbody>
</table>