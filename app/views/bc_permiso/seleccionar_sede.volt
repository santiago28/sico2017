
{{ content() }}
<h1>{{ titulo }}</h1>
<a href='/sico/bc_permiso/nuevo' class='btn btn-primary regresar'><i class='glyphicon glyphicon-chevron-left'></i> Atrás</a><br>
<h3>2. Selecciona la sede, puedes utilizar los filtros para encontrarla rápidamente</h3>
{% if (not(sedes is empty)) %}
<table id='sedes' class="table table-bordered table-hover">
	<thead>
    	 <tr>
            <th>Contrato - Modalidad<input autocomplete='off' class='filter form-control input-sm' name='contrato - modalidad' data-col='contrato - modalidad'/></th>
            <th>ID Sede - Nombre Sede<input autocomplete='off' class='filter form-control input-sm' name='id sede - nombre sede' data-col='id sede - nombre sede'/></th>
            <th colspan="2">Dirección<input autocomplete='off' class='filter form-control input-sm' name='dirección' data-col='dirección'/></th>
         </tr>
    </thead>
    <tbody>
    {% for sede in sedes %}
        <tr>
            <td>{{ sede.id_contrato }} - {{ sede.modalidad_nombre }}</td>
            <td>{{ sede.id_sede }} - {{ sede.sede_nombre }}</td>
            <td>{{ sede.sede_direccion }} ({{ sede.sede_barrio }})</td>
            <td><a href="/sico/bc_permiso/nuevo/{{ enlace }}/{{ sede.id_sede_contrato }}" class="btn btn-primary">Seleccionar <i class="glyphicon glyphicon-chevron-right"></i></a></td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{% endif %}