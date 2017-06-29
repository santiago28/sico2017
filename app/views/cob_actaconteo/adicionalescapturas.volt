{{ content() }}
{{ elements.getActamenu(acta) }}
{{ form("cob_actaconteo/guardaradicionalescapturas/"~id_actaconteo, "method":"post", "parsley-validate" : "", "id" : "adicionales_form", "enctype" : "multipart/form-data" ) }}
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
            <th>Captura SIBC</th>
            <th>Observación</th>
         </tr>
    </thead>
    <tbody>
    {% for adicional in adicionales %}
    <?php $fecha = $this->conversiones->fecha(2, $adicional->fechaInterventoria); ?>
    	<tr>
        	<td><span class="number">{{ loop.index }}</span></td>
        	<td>{{ adicional.numDocumento }}<input type="hidden" name="id_actaconteo_persona[]" value="{{ adicional.id_actaconteo_persona }}"></td>
        	<td>{{ adicional.primerNombre }}</td>
        	<td>{{ adicional.segundoNombre }}</td>
        	<td>{{ adicional.primerApellido }}</td>
        	<td>{{ adicional.segundoApellido }}</td>
            <td>{{ adicional.grupo }}</td>
            <td>{{ adicional.asistencia }}</td>
            <td class="imagen_imppnt">
				<input class="fileupload filestyle archivo{{ loop.index }}" data-input="false" data-badge="false" type="file" name="adicional[]" multiple>
			    <div id="progress" class="progress" style="margin: 0 !important;">
			        <div class="progress-bar progress-bar-success"></div>
			    </div>
			    <p><a class="captura" target="_blank" href="/sico/files/adicionales/{{ adicional.urlAdicional }}">{% if adicional.urlAdicional %}Clic para ver{% endif %}</a></p>
			    <input type='hidden' class='urlAdicional' name='urlAdicional[]' value='{{ adicional.urlAdicional }}'>
			</td>
            <td>{{ adicional.observacionAdicional }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
<div class="row container" style="padding-top: 10px;">
  {{ submit_button("Guardar", "class" : "btn btn-default pull-right") }}
</div>
</form>
<div class='clear'></div>
