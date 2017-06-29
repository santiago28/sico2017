
{{ content() }}
<h1>Fechas de Reporte para Ajustes</h1>
{{ link_to("cob_ajuste/", '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
{{ form("cob_ajuste/guardarfechareporte", "method":"post", "class":"form-container form-horizontal", "parsley-validate" : "") }}
<h3 style="margin-top: 0 !important">Nueva Fecha de Reporte</h3>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="fecha">Fecha</label>
        <div class="col-sm-10">
                {{ text_field("fecha", "type" : "date", "class" : "form-control tipo-fecha", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy") }}
        </div>
    </div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
          {{ submit_button("Guardar", "class" : "btn btn-default") }}
    </div>
</div>
</form>
{% if (not(fechas is empty)) %}
<!-- Modal -->
<div class="modal fade" id="eliminar_elemento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Eliminar</h4>
      </div>
      <div class="modal-body">
          <p>¿Estás seguro de que deseas eliminar la fecha de la base de datos?</p>
          <p><div class="alert alert-danger"><i class="glyphicon glyphicon-warning-sign"></i> <strong>Atención: </strong>Después de eliminado no podrá ser recuperado y la información asociada se perderá.</div></p>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" id="boton_eliminar">Eliminar</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<table class="table table-bordered table-hover">
    <thead>
        <tr><th>Acciones</th>
            <th>Fecha de Reporte de Ajustes</th>
            <th>Estado</th>
         </tr>
    </thead>
    <tbody>
    {% for fecha in fechas %}
        <tr>
        	<td><a href="#eliminar_elemento" rel="tooltip" title="Eliminar" class="eliminar_fila" data-toggle = "modal" id="{{ url("cob_ajuste/eliminarfechareporte/"~fecha.id_ajuste_reportado) }}"><i class="glyphicon glyphicon-trash"></i></a> {% if (fecha.estado == 1) %}{{ link_to("cob_ajuste/deshabilitarfechareporte/"~fecha.id_ajuste_reportado, "rel" : "tooltip", "title" : "Deshabilitar", "<i class='glyphicon glyphicon-remove'></i>" ) }}{% else %}{{ link_to("cob_ajuste/habilitarfechareporte/"~fecha.id_ajuste_reportado, "rel" : "tooltip", "title" : "Habilitar", "<i class='glyphicon glyphicon-ok'></i>" ) }}{% endif %}</td>
            <td>{{ fecha.fecha }}</td>
            <td>{{ fecha.getEstado() }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{% endif %}