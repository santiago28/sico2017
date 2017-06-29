{{ content() }}
{{ elements.getActathmenu(acta) }}
<!-- Modal -->
	<div class="modal fade" id="agregar_items" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Agregar ítems</h4>
	      </div>
	      <div class="modal-body">
	      <div class="alert alert-warning"><i class="glyphicon glyphicon-warning-sign"></i> El número de ítems debe de ser un número entre 1 y <span class="n2">20</span>, ya que sólo se permiten agregar niños adicionales en lotes de máximo 20 niños.</div>
	      	<div class="form-group">
			    <label for="n_items" class="col-sm-2 control-label">Ítems</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control required" id="n_items" name="n_items" placeholder="Número de ítems">
			    </div>
		  	</div>
		  	<br>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="button" class="btn btn-primary agregar_varios_items" data-dismiss="modal">Agregar</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="listado_empleados" style="display: none;">{{ listado_empleados }}</div>
{{ form("cob_actath/guardaradicionales/"~id_actath, "method":"post", "parsley-validate" : "", "id" : "adicionales_form", "enctype" : "multipart/form-data" ) }}
<table class="table table-bordered table-hover" id="{{ id_actath }}">
    <thead>
        <tr>
        	<th>#</th>
            <th>Documento</th>
            <th>Primer Nombre</th>
            <th>Segundo Nombre</th>
            <th>Primer Apellido</th>
            <th>Segundo Apellido</th>
						<th>Formación Académica</th>
						<th>Cargo</th>
						<th>Tipo Contrato</th>
						<th>Base Salario</th>
						<th>Pct Dedicación</th>
						<th>Fecha Ingreso</th>
						<th>Fecha Retiro</th>
            <th>Asistencia</th>
						<th>Observación</th>
            <th>X</th>
         </tr>
    </thead>
    <tbody>
    {% for adicional in adicionales %}
    <?php $fechaIngreso = $this->conversiones->fecha(2, $adicional->fechaIngreso);
		$fechaRetiro = $this->conversiones->fecha(2, $adicional->fechaRetiro);
		$dedicacion = $adicional->porcentajeDedicacion * 100;
		 ?>
    	<tr>
        	<td><span class="number">{{ loop.index }}</span></td>
        	<td><div class='texto'>{{ adicional.numDocumento }}</div>{{ text_field("num_documento[]", "value" : adicional.numDocumento, "disabled" : "disabled", "placeholder" : "Número de documento", "class" : "num_documento form-control required hide") }}<div class="error_documento"></div></td>
        	<td><div class='texto'>{{ adicional.primerNombre }}</div>{{ text_field("primerNombre[]", "value" : adicional.primerNombre, "disabled" : "disabled", "placeholder" : "Primer nombre", "class" : "form-control required hide") }}</td>
        	<td><div class='texto'>{{ adicional.segundoNombre }}</div>{{ text_field("segundoNombre[]", "value" : adicional.segundoNombre, "disabled" : "disabled", "placeholder" : "Segundo nombre", "class" : "form-control hide") }}</td>
        	<td><div class='texto'>{{ adicional.primerApellido }}</div>{{ text_field("primerApellido[]", "value" : adicional.primerApellido, "disabled" : "disabled", "placeholder" : "Primer apellido", "class" : "form-control required hide") }}</td>
        	<td><div class='texto'>{{ adicional.segundoApellido }}</div>{{ text_field("segundoApellido[]", "value" : adicional.segundoApellido, "disabled" : "disabled", "placeholder" : "Segundo apellido", "class" : "form-control hide") }}</td>
          <td><div class='texto'>{{ adicional.formacionAcademica }}</div>{{ text_field("formacionAcademica[]", "value" : adicional.formacionAcademica, "disabled" : "disabled", "placeholder" : "Formación Académica", "class" : "form-control required hide") }}</td>
					<td><div class='texto'>{{ adicional.cargo }}</div>{{ select("cargo[]", "value" : adicional.cargo, "disabled" : "disabled", cargo, "class" : "form-control cargo required hide") }}</td>
					<td><div class='texto'>{{ adicional.tipoContrato }}</div>{{ select("tipoContrato[]", "value" : adicional.tipoContrato, "disabled" : "disabled", tipoContrato, "class" : "form-control tipoContrato required hide") }}</td>
					<td><div class='texto'>{{ adicional.baseSalario }}</div>{{ text_field("baseSalario[]", "parsley-type" : "digits", "value" : adicional.baseSalario, "disabled" : "disabled", "placeholder" : "Base Salario", "class" : "form-control required hide") }}</td>
					<td><div class='texto'>{{ dedicacion }}</div>{{ text_field("porcentajeDedicacion[]", "parsley-range" : "[1,100]", "value" : dedicacion, "disabled" : "disabled", "placeholder" : "Porcentaje de Dedicación", "class" : "form-control required hide") }}</td>
					<td><div class='texto'>{{ fechaIngreso }}</div>{{ text_field("fechaIngreso[]", "value" : fechaIngreso, "disabled" : "disabled", "type" : "date", "class" : "form-control tipo-fecha fecha required hide", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy") }}</td>
					<td><div class='texto'>{{ fechaRetiro }}</div>{{ text_field("fechaRetiro[]", "value" : fechaRetiro, "disabled" : "disabled", "type" : "date", "class" : "form-control tipo-fecha fecha hide", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy") }}</td>
					<td><div class='texto'>{{ adicional.asistencia }}</div>{{ select("asistencia[]", "value" : adicional.asistencia, "disabled" : "disabled", asistencia, "class" : "form-control asistencia required hide") }}</td>
          <td><div class='texto'>{{ adicional.observacion }}</div>{{ text_area("observacion[]", "value" : adicional.observacion, "disabled" : "disabled", "rows" : "3", "class" : "form-control hide") }}</td>
          <td style="text-align:center;"><a id='{{ adicional.id_actath_persona }}' class='btn btn-default eliminar_guardado'><i class='glyphicon glyphicon-remove'></i></a><br><a class='btn btn-default editar_guardado'><i class='glyphicon glyphicon-edit'></i></a></td>
        </tr>
    {% endfor %}
	<?php for ($i = 1; $i <= 20; $i++) { ?>
        <tr style='display: none;'>
        	<td><span class="number"><?php echo $i; ?></span></td>
        	<td>{{ text_field("num_documento[]", "disabled" : "disabled", "placeholder" : "Número de documento", "class" : "num_documento form-control required") }}<div class="error_documento"></div></td>
        	<td>{{ text_field("primerNombre[]", "disabled" : "disabled", "placeholder" : "Primer nombre", "class" : "form-control required") }}</td>
        	<td>{{ text_field("segundoNombre[]", "disabled" : "disabled", "placeholder" : "Segundo nombre", "class" : "form-control") }}</td>
        	<td>{{ text_field("primerApellido[]", "disabled" : "disabled", "placeholder" : "Primer apellido", "class" : "form-control required") }}</td>
        	<td>{{ text_field("segundoApellido[]", "disabled" : "disabled", "placeholder" : "Segundo apellido", "class" : "form-control") }}</td>
					<td>{{ text_field("formacionAcademica[]", "disabled" : "disabled", "placeholder" : "Formación Académica", "class" : "form-control required") }}</td>
					<td>{{ select("cargo[]", "disabled" : "disabled", cargo, "class" : "form-control cargo required") }}</td>
          <td>{{ select("tipoContrato[]", "disabled" : "disabled", tipoContrato, "class" : "form-control tipoContrato required") }}</td>
					<td>{{ text_field("baseSalario[]", "parsley-type" : "digits", "disabled" : "disabled", "placeholder" : "Base Salario", "class" : "form-control required") }}</td>
					<td>{{ text_field("porcentajeDedicacion[]", "parsley-range" : "[1,100]", "disabled" : "disabled", "placeholder" : "Porcentaje Dedicación", "class" : "form-control required") }}</td>
					<td>{{ text_field("fechaIngreso[]", "disabled" : "disabled", "type" : "date", "class" : "form-control tipo-fecha fecha required", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy") }}</td>
					<td>{{ text_field("fechaRetiro[]", "disabled" : "disabled", "type" : "date", "class" : "form-control tipo-fecha fecha", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy") }}</td>
					<td>{{ select("asistencia[]", "disabled" : "disabled", asistencia, "class" : "form-control asistencia required") }}</td>
          <td>{{ text_area("observacion[]", "disabled" : "disabled", "rows" : "3", "class" : "form-control") }}</td>
          <td style="text-align:center;"><a class='btn btn-default eliminar_valor'><i class='glyphicon glyphicon-remove'></i></a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<div class="row container" style="margin-top: 10px;">
	<a id="agregar_item_adicional" class="btn btn-success pull-right"><i class="glyphicon glyphicon-plus"></i> Agregar 1 ítem</a>
	<a id="btn_varios_items" class="btn btn-success pull-right"><i class="glyphicon glyphicon-plus"></i> Agregar varios ítems</a>
</div>
<div class="row container alert alert-danger alerta_lote" style="margin-top: 10px; display: none;"></div>
<div class="row container" style="padding-top: 10px;">
	<input type="hidden" name="eliminar_adicionales" id="eliminar_adicionales">
  	<a class="btn btn-default pull-right submit_adicionales">Guardar</a>
</div>
</form>
<div class='clear'></div>
