{{ content() }}
{{ elements.getActamenu(acta) }}
<!-- Modal -->
<div class="modal fade" id="duplicar_fecha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Duplicar Fecha por Grupos</h4>
      </div>
      <div class="modal-body">
      		<div class="form-group">
		        <label class="col-sm-2 control-label" for="fecha">Fecha</label>
		        <div class="col-sm-10">
		                {{ text_field("fecha", "type" : "date", "class" : "form-control fecha_duplicar", "placeholder" : "dd/mm/aaaa", "data-date-format" : "dd/mm/yyyy") }}
		        </div>
		    </div>
      		<div class="form-group">
		        <label class="col-sm-2 control-label" for="modalidad">Grupos</label>
		        <div class="col-sm-10">
		        	<div class='btn btn-primary sel-todos form-control'>Seleccionar Todos</div><div style='margin-bottom: 3px;' class='clear'></div>
		        		{% for grupo in grupos %}
		        			<label class="btn btn-primary active">
		        			<input type="checkbox" class="grupo" value="{{ grupo['id_grupo'] }}" autocomplete="off"> {{ grupo['nombre_grupo'] }}
		        			</label>
		        		{% endfor  %}
		        </div>
		    </div>
          	<div class='clear'></div>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" id="boton_duplicar" data-dismiss="modal">Duplicar</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<a href='#duplicar_fecha' class='btn btn-primary' data-toggle="modal" style="margin-bottom: 5px;">Duplicar fecha por grupos</a>
{{ form("cob_actaconteo/guardarbeneficiarios/"~id_actaconteo, "method":"post", "parsley-validate" : "", "id" : "beneficiarios_form") }}
{{ hidden_field("periodo_tipo", "value": periodo_tipo) }}
<table class="table table-bordered table-hover">
    <thead>
        <tr>
        	<th>#</th>
            <th>Documento</th>
            <th>Nombre Completo</th>
            <th>Grupo</th>
            <th>Asistencia</th>
            <th>Excusa</th>
            {% if acta.id_modalidad == 3 or acta.id_modalidad == 5 or acta.id_modalidad == 7 %}<th><span class='fecha_visita_header'>Fecha Visita</th>{% endif %}
         </tr>
    </thead>
    <tbody>
    {% if(periodo_tipo != 2) %}
        {% for beneficiario in beneficiarios %}
      {% set nombre = {beneficiario.primerNombre, beneficiario.segundoNombre, beneficiario.primerApellido, beneficiario.segundoApellido} %}
      <?php $fecha = $this->conversiones->fecha(2, $beneficiario->fechaInterventoria); ?>
            <tr<?php echo $beneficiario->getAsistenciaDetail(); ?>>
              <td>{{ loop.index }}</td>
              <td>{{ beneficiario.numDocumento }}</td>
                <td>{{ nombre|join(' ') }}</td>
                <td><div class='hide id_grupo'>{{ beneficiario.id_grupo }}</div>{{ beneficiario.grupo }}</td>
                <td><input type="hidden" name="id_actaconteo_persona[]" value="{{ beneficiario.id_actaconteo_persona }}">{{ select("asistencia[]", asistencia, "value" : beneficiario.asistencia, "class" : "form-control asistencia required") }}</td>
                <td>
                <?php if($beneficiario->asistencia == 7 || $beneficiario->asistencia == 8){ ?>
                  <?php $fecha_excusa = $this->conversiones->fecha(2, $beneficiario->CobActaconteoPersonaExcusa->fecha); ?>
                  <input type="hidden" class="excusa" name="id_actaconteo_persona2[]" value="{{ beneficiario.id_actaconteo_persona }}">
                  {{ text_field("motivo[]", "placeholder" : "Motivo", "class" : "form-control excusa", "value" : beneficiario.CobActaconteoPersonaExcusa.motivo) }}
                  {{ text_field("fecha_excusa[]", "type" : "date", "class" : "form-control tipo-fecha excusa", "placeholder" : "Fecha: dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy", "value" : fecha_excusa) }}
                  {{ text_field("profesional[]", "placeholder" : "Profesional", "class" : "form-control excusa", "value" : beneficiario.CobActaconteoPersonaExcusa.profesional) }}
                  {{ text_field("telefono[]", "placeholder" : "Teléfono", "class" : "form-control excusa", "parsley-type" : "number", "value" : beneficiario.CobActaconteoPersonaExcusa.telefono) }}
                <?php } else { ?>
                  <input type="hidden" class="excusa" disabled="disabled" name="id_actaconteo_persona2[]" value="{{ beneficiario.id_actaconteo_persona }}">
                  {{ text_field("motivo[]", "placeholder" : "Motivo", "class" : "form-control hidden excusa", "disabled" : "disabled") }}
                  {{ text_field("fecha_excusa[]", "type" : "date", "class" : "form-control tipo-fecha hidden excusa", "placeholder" : "Fecha: dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy", "disabled" : "disabled") }}
                  {{ text_field("profesional[]", "placeholder" : "Profesional", "class" : "form-control hidden excusa", "disabled" : "disabled") }}
                  {{ text_field("telefono[]", "placeholder" : "Teléfono", "class" : "form-control hidden excusa", "parsley-type" : "number", "disabled" : "disabled") }}
                <?php } ?>
                </td>
                <td>{{ text_field("fecha[]", "type" : "date", "class" : "form-control tipo-fecha fecha", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy", "value" : fecha) }}</td>
            </tr>
        {% endfor %}
    {% else %}
        {% for beneficiario in beneficiarios %}
      {% set nombre = {beneficiario.primerNombre, beneficiario.segundoNombre, beneficiario.primerApellido, beneficiario.segundoApellido} %}
      <?php $fecha = $this->conversiones->fecha(2, $beneficiario->fechaInterventoria); ?>
            <tr<?php echo $beneficiario->getAsistenciaDetail2(); ?>>
              <td>{{ loop.index }}</td>
              <td>{{ beneficiario.numDocumento }}</td>
                <td>{{ nombre|join(' ') }}</td>
                <td><div class='hide id_grupo'>{{ beneficiario.id_grupo }}</div>{{ beneficiario.grupo }}</td>
                <td><input type="hidden" name="id_actaconteo_persona[]" value="{{ beneficiario.id_actaconteo_persona }}">{{ select("asistencia[]", asistenciaEC, "value" : beneficiario.asistencia, "class" : "form-control asistencia required") }}</td>
                <td>
                <?php if($beneficiario->asistencia == 4 || $beneficiario->asistencia == 5 || $beneficiario->asistencia == 6 || $beneficiario->asistencia == 7){ ?>
                  <?php $fecha_excusa = $this->conversiones->fecha(2, $beneficiario->CobActaconteoPersonaExcusa->fecha); ?>
                  <input type="hidden" class="excusa" name="id_actaconteo_persona2[]" value="{{ beneficiario.id_actaconteo_persona }}">
                  <?php if($beneficiario->asistencia == 4 || $beneficiario->asistencia == 7) { ?>
                    {{ text_field("motivo[]", "placeholder" : "Motivo", "class" : "form-control excusa", "value" : beneficiario.CobActaconteoPersonaExcusa.motivo) }}
                  <?php } else { ?>
                    {{ text_field("motivo[]", "placeholder" : "Gestión Telefónica", "class" : "form-control excusa", "value" : beneficiario.CobActaconteoPersonaExcusa.motivo) }}
                  <?php } ?>
                  {{ text_field("fecha_excusa[]", "type" : "date", "class" : "form-control tipo-fecha excusa", "placeholder" : "Fecha: dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy", "value" : fecha_excusa) }}
                  <?php if($beneficiario->asistencia == 4 || $beneficiario->asistencia == 7) { ?>
                    {{ text_field("profesional[]", "placeholder" : "Profesional", "class" : "form-control excusa", "value" : beneficiario.CobActaconteoPersonaExcusa.profesional) }}
                  <?php } else { ?>
                    {{ text_field("profesional[]", "placeholder" : "Acudiente", "class" : "form-control excusa", "value" : beneficiario.CobActaconteoPersonaExcusa.profesional) }}
                  <?php } ?>
                  {{ text_field("telefono[]", "placeholder" : "Teléfono", "class" : "form-control excusa", "parsley-type" : "number", "value" : beneficiario.CobActaconteoPersonaExcusa.telefono) }}
                <?php } else { ?>
                  <input type="hidden" class="excusa" disabled="disabled" name="id_actaconteo_persona2[]" value="{{ beneficiario.id_actaconteo_persona }}">
                  {{ text_field("motivo[]", "placeholder" : "Gestión Telefónica", "class" : "form-control hidden excusa", "disabled" : "disabled") }}
                  {{ text_field("fecha_excusa[]", "type" : "date", "class" : "form-control tipo-fecha hidden excusa", "placeholder" : "Fecha: dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy", "disabled" : "disabled") }}
                  {{ text_field("profesional[]", "placeholder" : "Acudiente", "class" : "form-control hidden excusa", "disabled" : "disabled") }}
                  {{ text_field("telefono[]", "placeholder" : "Teléfono", "class" : "form-control hidden excusa", "parsley-type" : "number", "disabled" : "disabled") }}
                <?php } ?>
                </td>
                <td>{{ text_field("fecha[]", "type" : "date", "class" : "form-control tipo-fecha fecha", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy", "value" : fecha) }}</td>
            </tr>
        {% endfor %}
    {% endif %}
    </tbody>
</table>
{{ submit_button("Guardar", "class" : "btn btn-default pull-right") }}
</form>
<div class='clear'></div>
