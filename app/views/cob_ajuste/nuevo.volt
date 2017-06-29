
{{ content() }}
{% set nombre = {beneficiario.primerNombre, beneficiario.segundoNombre, beneficiario.primerApellido, beneficiario.segundoApellido} %}
<h1>Nuevo Ajuste</h1>
<table class="table table-bordered table-hover">
	<thead>
        <tr>
            <th colspan="8" style="text-align: center; background-color: #F8F8F8;">Información del beneficiario</th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th>Documento</th>
            <th>Nombre Completo</th>
            <th>Prestador</th>
            <th>Contrato</th>
            <th>Sede</th>
            <th class='danger'>Periodo</th>
            <th>Estado Facturación</th>
						<th>Estado Liquidación</th>
         </tr>
    </thead>
    <tbody>
    <tr>
    	<td>{{ beneficiario.numDocumento }}</td>
    	<td>{{ nombre|join(' ') }}</td>
    	<td>{{ acta.oferente_nombre }}</td>
    	<td>{{ beneficiario.id_contrato }}</td>
    	<td>{{ acta.sede_nombre }}</td>
    	<td class='danger'>{{ periodo }}</td>
    	<td>{{ beneficiario.getEstadoDetail() }}</td>
			<td>{{ beneficiario.getEstadoLiquidacionDetail() }}</td>
    </tr>
    </tbody>
</table>
{{ link_to("cob_ajuste/", '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
{{ form("cob_ajuste/guardar/"~beneficiario.id_actaconteo_persona_facturacion, "method":"post", "id":"ajuste", "class":"form-container form-horizontal", "parsley-validate" : "") }}
<!-- Modal -->
<div class="modal fade" id="confirmacion_ajuste" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Ajuste</h4>
      </div>
      <div class="modal-body">
          <p>¿Estás seguro de que deseas realizar el ajuste para el beneficiario <strong>{{ nombre|join(' ') }}</strong> con número de documento <strong>{{ beneficiario.numDocumento }}</strong> del contrato <strong>{{ beneficiario.id_contrato }}</strong> para el periodo de <strong>{{ periodo }}</strong>?</p>
          <p><div class="alert alert-danger"><i class="glyphicon glyphicon-warning-sign"></i> <strong>Atención: </strong>Después de creado el ajuste no podrá ser modificado.</div></p>
      </div>
      <div class="modal-footer">
        {{ submit_button("Guardar", "class" : "btn btn-default") }}
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
	<div class="form-group">
        <label class="col-sm-2 control-label" for="certificar">* ¿Certificar?</label>
        <div class="col-sm-10">
                {{ select("certificar", sino, "class" : "form-control required") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="radicado">Número de radicado</label>
        <div class="col-sm-10">
               {{ text_field("radicado", "class" : "form-control") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="observacion">* Observación</label>
        <div class="col-sm-10">
                {{ text_area("observacion", "rows" : "4", "class" : "form-control required") }}
        </div>
    </div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    	<a class="btn btn-default confirmar_ajuste" data-toggle = "modal">Guardar</a>
    </div>
</div>
</form>
