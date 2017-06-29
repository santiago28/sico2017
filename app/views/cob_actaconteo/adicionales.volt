{{ content() }}
{{ elements.getActamenu(acta) }}
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
<a href='#duplicar_fecha' class='btn btn-primary' data-toggle="modal" style="margin-bottom: 5px;">Duplicar fecha por grupos</a>
<div id="listado_ninos" style="display: none;">{{ listado_ninos }}</div>
{{ form("cob_actaconteo/guardaradicionales/"~id_actaconteo, "method":"post", "parsley-validate" : "", "id" : "adicionales_form", "enctype" : "multipart/form-data" ) }}
<table class="table table-bordered table-hover" id="{{ id_actaconteo }}">
    <thead>
        <tr>
        	<th>#</th>
            <th>Documento</th>
            <th>Primer Nombre</th>
            <th>Segundo Nombre</th>
            <th>Primer Apellido</th>
            <th>Segundo Apellido</th>
            <th>Grupo</th>
            <th>Asistencia</th>
            {% if acta.id_modalidad == 3 or acta.id_modalidad == 5 or acta.id_modalidad == 7 %}<th><span class='fecha_visita_header'>Fecha Visita</th>{% endif %}
            <th>Captura SIBC</th>
            <th>Observación</th>
            <th>X</th>
         </tr>
    </thead>
    <tbody>
    {% for adicional in adicionales %}
    <?php $fecha = $this->conversiones->fecha(2, $adicional->fechaInterventoria); ?>
    	<tr>
        	<td><span class="number">{{ loop.index }}</span></td>
        	<td>{{ text_field("num_documento[]", "value" : adicional.numDocumento, "disabled" : "disabled", "placeholder" : "Número de documento", "class" : "num_documento form-control required") }}<div class="error_documento"></div></td>
        	<td>{{ text_field("primerNombre[]", "value" : adicional.primerNombre, "disabled" : "disabled", "placeholder" : "Primer nombre", "class" : "form-control required") }}</td>
        	<td>{{ text_field("segundoNombre[]", "value" : adicional.segundoNombre, "disabled" : "disabled", "placeholder" : "Segundo nombre", "class" : "form-control") }}</td>
        	<td>{{ text_field("primerApellido[]", "value" : adicional.primerApellido, "disabled" : "disabled", "placeholder" : "Primer apellido", "class" : "form-control required") }}</td>
        	<td>{{ text_field("segundoApellido[]", "value" : adicional.segundoApellido, "disabled" : "disabled", "placeholder" : "Segundo apellido", "class" : "form-control required") }}</td>
            <td>{{ text_field("grupo[]", "value" : adicional.grupo, "disabled" : "disabled", "placeholder" : "Grupo", "class" : "form-control required") }}</td>
            <td>{{ select("asistencia[]", "value" : adicional.asistencia, "disabled" : "disabled", asistencia, "class" : "form-control asistencia required") }}</td>                      
            {% if acta.id_modalidad == 3 or acta.id_modalidad == 5 or acta.id_modalidad == 7 %}<td>{{ text_field("fecha[]", "value" : fecha, "disabled" : "disabled", "type" : "date", "class" : "form-control tipo-fecha required fecha", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy") }}</td>{% endif %}
            <td class="imagen_imppnt">
				<input disabled="disabled" class="fileupload filestyle" data-input="false" data-badge="false" type="file" name="adicional[]" multiple>
			    <div id="progress" class="progress" style="margin: 0 !important;">
			        <div class="progress-bar progress-bar-success"></div>
			    </div>
			    <p><a class="captura" target="_blank" href="/sico/files/adicionales/{{ adicional.urlAdicional }}">{% if adicional.urlAdicional %}Clic para ver{% endif %}</a></p>
			    <input disabled="disabled" type='hidden' class='urlAdicional' name='urlAdicional[]' value='{{ adicional.urlAdicional }}'>
			</td>
            <td>{{ text_area("observacion[]", "value" : adicional.observacionAdicional, "disabled" : "disabled", "rows" : "3", "class" : "form-control") }}</td>
            <td style="text-align:center;"><a id='{{ adicional.id_actaconteo_persona }}' class='btn btn-default eliminar_guardado'><i class='glyphicon glyphicon-remove'></i></a><br><a class='btn btn-default editar_guardado'><i class='glyphicon glyphicon-edit'></i></a></td>
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
            <td>{{ text_field("grupo[]", "disabled" : "disabled", "placeholder" : "Grupo", "class" : "form-control required") }}</td>
            <td>
				{% if(acta.id_modalidad == 5 ) %}
					{{ select("asistencia[]", "disabled" : "disabled", asistenciaEC, "class" : "form-control asistencia required") }}</td>                      
				{% else %}
					{{ select("asistencia[]", "disabled" : "disabled", asistencia, "class" : "form-control asistencia required") }}</td>                      
				{% endif %}
            {% if acta.id_modalidad == 3 or acta.id_modalidad == 5 or acta.id_modalidad == 7 %}<td>{{ text_field("fecha[]", "disabled" : "disabled", "type" : "date", "class" : "form-control tipo-fecha required fecha", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy") }}</td>{% endif %}
            <td class="imagen_imppnt">
				<input disabled="disabled" class="fileupload filestyle" data-input="false" data-badge="false" type="file" name="adicional[]" multiple>
			    <div id="progress" class="progress" style="margin: 0 !important;">
			        <div class="progress-bar progress-bar-success"></div>
			    </div>
			    <input disabled="disabled" type='hidden' class='urlAdicional' name='urlAdicional[]' value=''>
			</td>
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