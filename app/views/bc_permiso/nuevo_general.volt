
{{ content() }}
<h1>{{ titulo }}</h1>
<a href='/sico/bc_permiso/nuevo/<?php echo $categoria; ?>' class='btn btn-primary regresar'><i class='glyphicon glyphicon-chevron-left'></i> Atrás</a><br><br>
<table class='table table-bordered table-hover nuevo_general' id="{{ id_sede_contrato }}">
	<thead>
		<tr>
			<th>Contrato - Modalidad</th>
			<th>ID Sede - Nombre Sede</th>
			<th>Dirección</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{ sede.id_contrato }} - {{ sede.modalidad_nombre }}</td>
			<td>{{ sede.id_sede }} - {{ sede.sede_nombre }}</td>
			<td>{{ sede.sede_direccion }} ({{ sede.sede_barrio }})</td>
		</tr>
	</tbody>
</table>
<h3>3. Ingresa los campos del permiso</h3>
<div id="festivos" style="display:none"><?php echo $this->elements->festivos(); ?></div>
{{ form("bc_permiso/crear_general/"~id_sede_contrato~"/"~id_categoria, "id":"permiso_general_form", "method":"post", "class":"form-container form-horizontal", "parsley-validate" : "") }}
<!-- Modal -->
<div class="modal fade" id="modal_participantes" tabindex="-1" role="dialog" aria-labelledby="modal_participantes" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="modal_participantes">Agregar participantes</h4>
      </div>
      <div class="modal-body">
				<p>Puede copiar los beneficiarios directamente desde un archivo en Excel, seleccionando los datos de las columnas 'Nombre completo' y 'Nuip' en ese mismo orden como se muestra en <a id="paso1">esta imagen</a> y pegándolos en el cuadro siguiente como se puede <a id="paso2">ver aquí</a>.</p>
				{{ text_area("pegar_listado", "rows" : 2, "placeholder" : "Pegue aquí el listado de beneficiarios", "class" : "form-control", "style" : "margin-bottom: 5px;") }}
				<table class="table table-bordered table-hover" id="listado_participantes_tabla">
					<thead>
						<tr>
							<th>#</th>
							<th>Nombre Completo</th>
							<th>Número de Documento</th>
							<th>X</th>
						</tr>
					</thead>
					<tbody>
						<?php for ($i = 1; $i <= 500; $i++) { ?>
							<tr style="display: none;">
								<td><span class="number"><?php echo $i; ?></span></td>
								<td>{{ text_field("nombreCompleto[]", "disabled" : "disabled", "placeholder" : "Nombre Completo", "class" : "nombreCompleto form-control required") }}<div class="error_nombre"></div></td>
								<td>{{ text_field("numDocumento[]", "disabled" : "disabled", "placeholder" : "Número de documento", "class" : "numDocumento form-control required") }}<div class="error_documento"></div></td>
								<td style="text-align:center;"><a class='btn btn-default eliminar_valor'><i class='glyphicon glyphicon-remove'></i></a></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<div class="row container alerta_lote" style="padding-top: 10px; display: none;"></div>
      </div>
      <div class="modal-footer">
				<a class="btn btn-success pull-left" id="agregar_item_adicional"><i class="glyphicon glyphicon-plus"></i> Agregar Ítem</a>
				<a class="btn btn-success pull-left" id="limpiar_formulario"><i class="glyphicon glyphicon-refresh"></i> Limpiar Formulario</a>
        <a class="btn btn-primary submit_listado"><i class="glyphicon glyphicon-save"></i> Guardar Listado</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
	<div class="form-group">
        <label class="col-sm-2 control-label" for="titulo">Nombre Evento</label>
        <div class="col-sm-10">
                {{ text_field("titulo", "maxlength" : "25", "parsley-maxlength" : "25", "class" : "form-control required", "autocomplete" : "on") }}
                <div class="max">25 caracteres máximo</div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="tipo_permiso">¿Repetir?</label>
        <div class="col-sm-10">
            <select id="tipo_permiso" name="tipo_permiso" class="form-control">
					<option value="0">No repetir</option>
					<option value="1">Repetir Semanalmente</option>
					<option value="2">Repetir Quincenalmente</option>
			</select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="fecha">Fecha</label>
        <div class="col-sm-10">
                {{ text_field("fecha", "type" : "date", "class" : "form-control tipo-fecha required", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy") }}
        </div>
    </div>
    <div class="form-group" style="display:none">
        <label class="col-sm-2 control-label" for="fecha_inicio_permiso">Fecha Inicio</label>
        <div class="col-sm-10">
                {{ text_field("fecha_inicio_permiso", "type" : "date", "class" : "form-control tipo-fecha required", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy", "disabled" : "disabled") }}
        </div>
    </div>
    <div class="form-group" style="display:none">
        <label class="col-sm-2 control-label" for="fecha_fin_permiso">Fecha Fin</label>
        <div class="col-sm-10">
                {{ text_field("fecha_fin_permiso", "type" : "date", "class" : "form-control tipo-fecha required", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy", "disabled" : "disabled") }}
        </div>
    </div>
    <div class="form-group" style="display:none">
        <label class="col-sm-2 control-label dias_permiso" for="dias_permiso">Días Permiso</label>
        <div class="col-sm-10">
				<label class="checkbox-inline">
				  <input class="dia" type="checkbox" name="dias[]" id="Monday" value="Monday" disabled="disabled"> Lun
				</label>
				<label class="checkbox-inline">
				  <input class="dia" type="checkbox" name="dias[]" id="Tuesday" value="Tuesday" disabled="disabled"> Mar
				</label>
				<label class="checkbox-inline">
				  <input class="dia" type="checkbox" name="dias[]" id="Wednesday" value="Wednesday" disabled="disabled"> Mié
				</label>
				<label class="checkbox-inline">
				  <input class="dia" type="checkbox" name="dias[]" id="Thursday" value="Thursday" disabled="disabled"> Jue
				</label>
				<label class="checkbox-inline">
				  <input class="dia" type="checkbox" name="dias[]" parsley-mincheck="1" id="Friday" value="Friday" disabled="disabled"> Vie
				</label>
		</div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="horaInicio">Hora Inicio</label>
        <div class="col-sm-10 hora">
                {{ text_field("horaInicio", "class" : "form-control required time start") }}
        </div>
    </div>
    <div class="form-group hora">
        <label class="col-sm-2 control-label" for="horaFin">Hora Fin</label>
        <div class="col-sm-10">
                {{ text_field("horaFin", "class" : "form-control required time end") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="observaciones">Objetivo de la salida</label>
        <div class="col-sm-10">
                {{ text_area("observaciones", "maxlength" : "150", "parsley-maxlength" : "150", "rows" : "4", "class" : "form-control required") }}
                <div class="max">150 caracteres máximo</div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="actores">Actores que Apoyan el Evento</label>
        <div class="col-sm-10">
                {{ text_field("actores", "maxlength" : "50", "parsley-maxlength" : "50", "class" : "form-control required", "autocomplete" : "on") }}
                <div class="max">50 caracteres máximo</div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="direccionEvento">Dirección y Lugar del Evento</label>
        <div class="col-sm-10">
                {{ text_field("direccionEvento", "maxlength" : "80", "parsley-maxlength" : "80", "class" : "form-control required", "autocomplete" : "on") }}
                <div class="max">80 caracteres máximo</div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="personaContactoEvento">Persona Contacto del Escenario</label>
        <div class="col-sm-10">
                {{ text_field("personaContactoEvento", "maxlength" : "80", "parsley-maxlength" : "80", "class" : "form-control required", "autocomplete" : "on") }}
                <div class="max">80 caracteres máximo</div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="telefonoContactoEvento">Teléfonos de la Persona de Contacto</label>
        <div class="col-sm-10">
                {{ text_field("telefonoContactoEvento", "maxlength" : "80", "parsley-maxlength" : "80", "class" : "form-control required", "autocomplete" : "on") }}
                <div class="max">80 caracteres máximo</div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="emailContactoEvento">Email de la Persona de Contacto</label>
        <div class="col-sm-10">
                {{ email_field("emailContactoEvento", "maxlength" : "80", "parsley-maxlength" : "80", "class" : "form-control required", "autocomplete" : "on") }}
                <div class="max">80 caracteres máximo</div>
        </div>
    </div>
    <div class="form-group">
    	<label class="col-sm-2 control-label" for="listadoNinios">Listado de Niños Participantes</label>
			<div class="col-sm-2">
				<div class="input-group">
					<span class="input-group-addon"><span id="num_participantes">0</span> participantes agregados</span>
					<span class="input-group-btn">
						<a href="#modal_participantes" data-toggle = "modal" title="Agregar Participantes" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Agregar participantes</a>
					</span>
				</div>
			</div>
	</div>
	<div class="form-group">
        <label class="col-sm-2 control-label" for="requiereTransporte">¿Requiere Transporte?</label>
        <div class="col-sm-10">
        	<div class="btn-group" data-toggle="buttons">
			  <label class="btn btn-primary requiere_transporte">
			    <input type="radio" name="requiereTransporte" id="option1" autocomplete="off" value="1"> Sí
			  </label>
			  <label class="btn btn-primary no_requiere_transporte">
			    <input type="radio" name="requiereTransporte" id="option2" autocomplete="off" value="2" class="required"> No
			  </label>
			</div>
        </div>
    </div>
	<div class="form-group transporte">
    	<label class="col-sm-2 control-label" for="runtConductor">RUNT del Conductor</label>
		<div class="col-sm-10 imagen_imppnt">
			<input disabled="disabled" class="fileupload filestyle" data-tipo = "imgpdf" data-input="false" data-badge="false" type="file" name="archivo[]" multiple>
		    <div id="progress" class="progress" style="margin: 0 !important;">
		        <div class="progress-bar progress-bar-success"></div>
		    </div>
		    <input disabled="disabled" style="display:none" type='text' class='urlArchivo required' name='runtConductor' value=''>
		</div>
	</div>
	<div class="form-group transporte">
    	<label class="col-sm-2 control-label" for="runtVehiculo">RUNT del Vehículo</label>
		<div class="col-sm-10 imagen_imppnt">
			<input disabled="disabled" class="fileupload filestyle" data-tipo = "imgpdf" data-input="false" data-badge="false" type="file" name="archivo[]" multiple>
		    <div id="progress" class="progress" style="margin: 0 !important;">
		        <div class="progress-bar progress-bar-success"></div>
		    </div>
		    <input disabled="disabled" style="display:none" type='text' class='urlArchivo required' name='runtVehiculo' value=''>
		</div>
	</div>
	<div class="form-group transporte">
    	<label class="col-sm-2 control-label" for="polizaResponsabilidadCivil">Póliza Responsabilidad Civil</label>
		<div class="col-sm-10 imagen_imppnt">
			<input disabled="disabled" class="fileupload filestyle" data-tipo = "imgpdf" data-input="false" data-badge="false" type="file" name="archivo[]" multiple>
		    <div id="progress" class="progress" style="margin: 0 !important;">
		        <div class="progress-bar progress-bar-success"></div>
		    </div>
		    <input disabled="disabled" style="display:none" type='text' class='urlArchivo required' name='polizaResponsabilidadCivil' value=''>
		</div>
	</div>
	<div class="form-group transporte">
    	<label class="col-sm-2 control-label" for="tarjetaOperacionVehiculo">Tarjeta de Operación del Vehículo</label>
		<div class="col-sm-10 imagen_imppnt">
			<input disabled="disabled" class="fileupload filestyle" data-tipo = "imgpdf" data-input="false" data-badge="false" type="file" name="archivo[]" multiple>
		    <div id="progress" class="progress" style="margin: 0 !important;">
		        <div class="progress-bar progress-bar-success"></div>
		    </div>
		    <input disabled="disabled" style="display:none" type='text' class='urlArchivo required' name='tarjetaOperacionVehiculo' value=''>
		</div>
	</div>
	<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    	  <input type="hidden" name="fecha_inicio" id="fecha_inicio" value="<?php echo date('d/m/Y',strtotime('+15 days')); ?>">
		  <input type="hidden" name="fecha_fin" id="fecha_fin" value="<?php echo "01/01/" . date('Y',strtotime('+1 year')); ?>"">
          {{ submit_button("Guardar", "class" : "btn btn-default") }}
    </div>
</div>
</form>
