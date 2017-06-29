
{{ content() }}
<h1>{{ titulo }}</h1>
{{ link_to("cob_periodo/ver/"~id_periodo, '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
{% if (nivel <= 2) %}
{{ link_to("cob_periodo/rutear/"~id_periodo~"/"~recorrido, '<i class="glyphicon glyphicon-road"></i> Rutear', "class": "btn btn-primary menu-tab") }}
{% endif %}
{{ link_to("cob_periodo/gdocumental/"~id_periodo~"/"~recorrido, '<i class="glyphicon glyphicon-file"></i> Gestión Documental', "class": "btn btn-primary menu-tab") }}
<!-- Modal -->
<div class="modal fade" id="eliminar_elemento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Eliminar</h4>
      </div>
      <div class="modal-body">
          <p>¿Estás seguro de que deseas eliminar el elemento con ID <span class="fila_eliminar"></span> de la base de datos?</p>
          <p><div class="alert alert-danger"><i class="glyphicon glyphicon-warning-sign"></i> <strong>Atención: </strong>Después de eliminado no podrá ser recuperado y la información asociada se perderá.</div></p>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" id="boton_eliminar">Eliminar</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<table class="table table-bordered table-hover" id="recorrido">
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
<!--

  {% if (cob_periodo.tipo == 2) %}
              {% if (nivel <= 1) %}
                <a href="#eliminar_elemento" rel="tooltip" title="Eliminar" class="eliminar_fila" data-toggle = "modal" id="{{ url("cob_actamuestreo/eliminar/"~acta.id_actamuestreo) }}"><i class="glyphicon glyphicon-trash"></i></a>
              {% endif %}
            {% endif %}
-->
