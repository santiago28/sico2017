<h1>Permiso ID {{ permiso.id_permiso }}</h1>
<!-- Modal -->
<div class="modal fade" id="aprobar_permiso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Aprobando Permiso ID <span class="fila_eliminar"></span></h4>
      </div>
      <div class="modal-body">
      {{ form("bc_permiso/aprobarbc/", "method":"post", "class":"", "id":"aprobar_permiso", "parsley-validate" : "") }}
          <p>Escribe el motivo por el cual vas a <span style='color: #5cb85c; font-weight: bold'>aprobar</span> el permiso ID <span class="fila_eliminar"></span>:</p>
          <input type="hidden" name="id_permiso" class="id_elemento">
          <p>
          {{ text_area("observacion", "maxlength" : "400", "parsley-maxlength" : "400", "rows" : "4", "class" : "form-control salidas", "value" : texto_aprobar['aprobar_salida']) }}
          {{ text_area("observacion", "maxlength" : "400", "parsley-maxlength" : "400", "rows" : "4", "class" : "form-control jornadas", "value" : texto_aprobar['aprobar_jornada'], "disabled" : "disabled", "style" : "display:none;") }}
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-primary active" id="btn_salidas">
              <input type="radio" name="options" autocomplete="off" checked> Mensaje Salidas
            </label>
            <label class="btn btn-primary" id="btn_jornadas">
              <input type="radio" name="options" autocomplete="off"> Mensaje Jornadas
            </label>
          </div>
          </p>
      </div>
      <div class="modal-footer">
        {{ submit_button("Aprobar", "class" : "btn btn-primary") }}
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal -->
<div class="modal fade" id="eliminar_elemento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Anulando Permiso ID <span class="fila_eliminar"></span></h4>
      </div>
      <div class="modal-body">
      {{ form("bc_permiso/anular/", "method":"post", "class":"", "id":"anular_permiso", "parsley-validate" : "") }}
          <p>Escribe el motivo por el cual vas a <span style='color: #d9534f; font-weight: bold'>anular</span>  el permiso ID <span class="fila_eliminar"></span>:</p>
          <p>{{ text_area("observacion", "maxlength" : "150", "parsley-maxlength" : "150", "rows" : "4", "class" : "form-control required") }}</p>
          <input type="hidden" name="id_permiso" class="id_elemento">
      </div>
      <div class="modal-footer">
        {{ submit_button("Anular", "class" : "btn btn-primary") }}
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<a href='/sico/bc_permiso/mes' class='btn btn-primary regresar'><i class='glyphicon glyphicon-chevron-left'></i> Lista de Permisos</a>{{ accion_permiso }}<br><br>
<table class='table table-bordered table-hover'>
	<thead>
		<tr>
			<th colspan="4" style="text-align:center;">INFORMACIÓN SEDE</th>
		</tr>
		<tr>
			<th>Contrato - Modalidad</th>
			<th>ID Sede - Nombre Sede</th>
			<th>Dirección Sede</th>
			<th>Teléfono Sede</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{ permiso.BcSedeContrato.id_contrato }} - {{ permiso.BcSedeContrato.modalidad_nombre }}</td>
			<td>{{ permiso.BcSedeContrato.id_sede }} - {{ permiso.BcSedeContrato.sede_nombre }}</td>
			<td>{{ permiso.BcSedeContrato.sede_direccion }} ({{ permiso.BcSedeContrato.sede_barrio }})</td>
			<td>{{ permiso.BcSedeContrato.sede_telefono }}</td>
		</tr>
	</tbody>
</table>
