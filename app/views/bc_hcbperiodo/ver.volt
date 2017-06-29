
{{ content() }}
<h1>Hogares Comunitarios - {{ mes }}</h1>
{{ link_to("bc_hcbperiodo/", '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
{% if (not(sedes is empty)) %}
<table class="table table-bordered table-hover" id="recorrido">
    <thead>
        <tr><th>#</th>
            <th>No. Contrato</th>
            {% if (nivel <= 2 ) %}<th>Prestador</th>{% endif %}
            <th>Sede</th>
            <th>Madre Comunitaria</th>
         </tr>
    </thead>
    <tbody>
    {% for sede in sedes %}
        <tr>
        	<td>{{ loop.index }}</td>
            <td>{{ sede.id_contrato }}</td>
            {% if (nivel <= 2 ) %}<td>{{ sede.oferente_nombre }}</td>{% endif %}
            <td>{{ sede.sede_nombre }}</td>
            <td>{{ sede.CobActaconteo.CobActaconteoMcb.getNombrecompleto() }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{% endif %}
