{{ content() }}
{{ elements.getActaverificacionmenu(acta) }}
{{ form("cob_actatelefonica/guardarbeneficiarios/"~acta.id_acta, "method":"post", "parsley-validate" : "", "id" : "beneficiarios_form") }}
<table class="table table-bordered table-hover">
    <thead>
        <tr>
        	<th>#</th>
            <th>Documento</th>
            <th>Nombre Completo</th>
            <th>Grupo</th>
            <th>Teléfono</th>
            <th>Asistencia</th>
            <th>Teléfono Contacto</th>
            <th>Persona que contesta</th>
            <th>Parentesco</th>
            <th>Observación</th>
         </tr>
    </thead>
    <tbody>
    {% for beneficiario in beneficiarios %}  
	{% set nombre = {beneficiario.primerNombre, beneficiario.segundoNombre, beneficiario.primerApellido, beneficiario.segundoApellido} %}
        <tr>
        	<td>{{ loop.index }}</td>
        	<td><input type="hidden" name="id_actatelefonica_persona[]" value="{{ beneficiario.id_actatelefonica_persona }}">{{ beneficiario.numDocumento }}</td>
            <td>{{ nombre|join(' ') }}</td>
            <td>{{ beneficiario.grupo }}</td>
            <td>{{ beneficiario.beneficiarioTelefono }}</td>
            <td>{{ select("asistencia[]", asistencia, "value" : beneficiario.asistencia, "class" : "form-control asistencia required") }}</td>
            <td>{{ text_field("telefonoContacto[]", "value" : beneficiario.telefonoContacto, "class" : "form-control") }}</td>
            <td>{{ text_field("personaContesta[]", "value" : beneficiario.personaContesta, "class" : "form-control") }}</td>
            <td>{{ text_field("parentesco[]", "value" : beneficiario.parentesco, "class" : "form-control") }}</td>
            <td>{{ text_field("observacion[]", "value" : beneficiario.observacion, "class" : "form-control") }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{{ submit_button("Guardar", "class" : "btn btn-default pull-right") }}
</form>
<div class='clear'></div>

