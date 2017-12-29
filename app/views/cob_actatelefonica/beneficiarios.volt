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
            <th>Teléfono 1</th>
            <th>Teléfono 2</th>
            <th>Celular</td>
            <th>Asistencia</th>
            <th style="width:12%;">Teléfono Contacto</th>
            <th style="width:12%;">Persona que contesta</th>
            <th style="width:12%;">Parentesco</th>
            <th style="width:17%;">Observación</th>
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
            <td>{{ beneficiario.getTelefonoBeneficiario() }}</td>
            <td>{{ beneficiario.beneficiarioTelefono}}</td>
            <td>{{ beneficiario.beneficiarioCelular }}</td>
            <td>{{ select("asistencia[]", asistencia, "value" : beneficiario.asistencia, "class" : "form-control asistencia required") }}</td>
            <td>{{ text_field("telefonoContacto[]", "value" : beneficiario.telefonoContacto, "class" : "form-control") }}</td>
            <td>{{ text_field("personaContesta[]", "value" : beneficiario.personaContesta, "class" : "form-control") }}</td>
            <td>{{ text_field("parentesco[]", "value" : beneficiario.parentesco, "class" : "form-control") }}</td>
            <!--<td>{{ text_field("observacion[]", "value" : beneficiario.observacion, "class" : "form-control") }}</td>-->
            <td><textarea class='form-control' name='observacion[]' rows='3' cols='100'>{{ beneficiario.observacion }}</textarea></td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{{ submit_button("Guardar", "class" : "btn btn-default pull-right") }}
</form>
<div class='clear'></div>
