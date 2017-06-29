
{{ content() }}
<h1>Empleados - Cronograma Hogares Comunitarios</h1>
{{ elements.getcronogramahcbMenuIbc() }}
{% if (not(empleados is empty)) %}
<table class="table table-bordered table-hover filtro_hcb">
    <thead>
        <tr><th>#</th>
            <th>Prestador</th>
            <th>Número de Documento</th>
            <th>Nombre Completo</th>
         </tr>
    </thead>
    <thead>
      <tr><th style="margin: 0; padding: 0; border: 0" colspan="9"><a id='cleanfilters' class='btn btn-primary btn-sm btn-block'>Limpiar Filtros</a></th></tr>
    </thead>
    <tbody>
    {% for empleado in empleados %}
        <tr>
        	<td>{{ loop.index }}</td>
            <td>{{ empleado.BcSedeContrato.oferente_nombre }}</td>
            <td>{{ empleado.numDocumento }}</td>
            <td>{{ empleado.getNombrecompleto() }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{% endif %}
