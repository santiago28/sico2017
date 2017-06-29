
{{ content() }}
<h1>Novedades {{ mes }}</h1>
{{ elements.getcronogramahcbMenuIbc() }}
<ol class="breadcrumb">
  <li>{{ link_to("bc_hcb/", 'Periodos') }}</li>
  <li class="active">Novedades {{ mes }}</li>
</ol>
{% if (not(novedades is empty)) %}
<table class="table table-bordered table-hover filtro_hcb">
    <thead>
        <tr><th>#</th>
          <th>Prestador</th>
          <th>No. Contrato</th>
          <th>Sede</th>
          <th>Empleado</th>
          <th>Fecha Visita</th>
          <th>Creado</th>
          <th>Cancelado</th>
          <th>Estado</th>
         </tr>
    </thead>
    <thead>
    	<tr><th style="margin: 0; padding: 0; border: 0" colspan="9"><a id='cleanfilters' class='btn btn-primary btn-sm btn-block'>Limpiar Filtros</a></th></tr>
    </thead>
    <tbody>
    {% for novedad in novedades %}
        <tr>
        	<td>{{ loop.index }}</td>
            <td>{{ novedad.BcSedeContrato.oferente_nombre }}</td>
            <td>{{ novedad.BcSedeContrato.id_contrato }}</td>
            <td>{{ novedad.BcSedeContrato.sede_nombre }}</td>
            <td>{{ novedad.BcHcbperiodoEmpleado.BcHcbempleado.getNombrecompleto() }}</td>
            <td><?php echo $this->conversiones->fecha(4, $novedad->fecha); ?></td>
            <td><?php echo $this->conversiones->hora(2, $novedad->fechahoraCreacion); ?></td>
            <td><?php echo $this->conversiones->hora(2, $novedad->fechahoraCancelacion); ?></td>
            <td>{% if (novedad.estado == 1) %}<a rel='tooltip' title='Observación: {{ novedad.observacionCancelacion }}' >{% endif %}<span class="label label-{{ novedad.labelEstado() }}">{{ novedad.getEstado() }}</span>{% if (novedad.estado == 1) %}</a>{% endif %}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{% endif %}
