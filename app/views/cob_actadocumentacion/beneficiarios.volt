{{ content() }}
{{ elements.getActaverificacionmenu(acta) }}
{{ form("cob_actadocumentacion/guardarbeneficiarios/"~acta.id_acta, "method":"post", "parsley-validate" : "", "id" : "beneficiarios_form") }}
<table class="table table-bordered table-hover">
    <thead>
        <tr>
        	<th>#</th>
            <th>Documento</th>
            <th>Nombre Completo</th>
            <th>Grupo</th>
            <th>Nombre y Nuip SIBC</th>
            <th>Tel o Cel SIBC</th>
            <th>Cert. SGS</th>
            <th>Cert. Sisbén</th>
            <th>Matr. Firmada</th>
            <th>Fecha Matr.</th>
         </tr>
    </thead>
    <tbody>
    {% for beneficiario in beneficiarios %}  
	{% set nombre = {beneficiario.primerNombre, beneficiario.segundoNombre, beneficiario.primerApellido, beneficiario.segundoApellido} %}
        <tr>
        	<td>{{ loop.index }}</td>
        	<td><input type="hidden" name="id_actadocumentacion_persona[]" value="{{ beneficiario.id_actadocumentacion_persona }}">{{ beneficiario.numDocumento }}</td>
            <td>{{ nombre|join(' ') }}</td>
            <td>{{ beneficiario.grupo }}</td>
            <td<?php echo $beneficiario->getsinonareDetail($beneficiario->nombreCedulaSibc); ?>>{{ select("nombreCedulaSibc[]", sinonare, "value" : beneficiario.nombreCedulaSibc, "class" : "form-control sinonare required") }}</td>
            <td<?php echo $beneficiario->getsinonareDetail($beneficiario->telefonoSibc); ?>>{{ select("telefonoSibc[]", sinonare, "value" : beneficiario.telefonoSibc, "class" : "form-control sinonare required") }}</td>
            <td<?php echo $beneficiario->getsinonareDetail($beneficiario->certificadoSgs); ?>>{{ select("certificadoSgs[]", sinonare, "value" : beneficiario.certificadoSgs, "class" : "form-control sinonare required") }}</td>
            <td<?php echo $beneficiario->getsinonareDetail($beneficiario->certificadoSisben); ?>>{{ select("certificadoSisben[]", sinonare, "value" : beneficiario.certificadoSisben, "class" : "form-control sinonare required") }}</td>
            <td<?php echo $beneficiario->getsinonareDetail($beneficiario->matriculaFirmada); ?>>{{ select("matriculaFirmada[]", sinonare, "value" : beneficiario.matriculaFirmada, "class" : "form-control sinonare required") }}</td>
            <td<?php echo $beneficiario->getsinonareDetail($beneficiario->fechaMatricula); ?>>{{ select("fechaMatricula[]", sinonare, "value" : beneficiario.fechaMatricula, "class" : "form-control sinonare required") }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{{ submit_button("Guardar", "class" : "btn btn-default pull-right") }}
</form>
<div class='clear'></div>

