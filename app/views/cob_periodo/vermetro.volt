
{{ content() }}
<h1>Periodo {{ fecha_periodo }}</h1>
<!-- Modal -->
<div class="modal fade" id="confirmacion_cierre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Confirmar cierre de periodo</h4>
      </div>
      <div class="modal-body">
          <p>¿Estás seguro de que deseas cerrar el periodo <strong>{{ fecha_periodo }}</strong>?</p>
          <p><div class="alert alert-danger"><i class="glyphicon glyphicon-warning-sign"></i> <strong>Atención: </strong>Después de cerrado el periodo no podrá ser modificado.</div></p>
      </div>
      <div class="modal-footer">
        {{ link_to("cob_periodo/cerrar/"~id_periodo,  "Cerrar Periodo", "class": "btn btn-default") }}
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{ link_to("cob_periodo/index", '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
{% if (not(recorridos is empty)) %}
{% for recorrido in recorridos %}
{{ link_to("cob_periodo/recorrido/"~id_periodo~"/"~recorrido.recorrido, "Recorrido "~recorrido.recorrido, "class": "btn btn-default btn-lg btn-block") }}
{% endfor %}
{% endif %}
{% if (nivel <= 1) %}
{% if crear_recorrido == 1 %}
{{ link_to("cob_periodo/nuevorecorrido1/"~id_periodo, "Generar Recorrido 1", "class": "btn btn-primary btn-lg btn-block") }}
{% else %}
{{ link_to("cob_periodo/nuevorecorrido/"~id_periodo,  "Generar Recorrido "~crear_recorrido, "class": "btn btn-primary btn-lg btn-block") }}
{% endif %}
{% endif %}
