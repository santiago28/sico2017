{{ content() }}
{{ elements.getActaverificacionmenu(acta) }}
{{ form("cob_actafocalizacion/guardarbeneficiarios/"~acta.id_acta, "method":"post", "parsley-validate" : "", "id" : "beneficiario_form", "enctype" : "multipart/form-data") }}
<table class="table table-bordered table-hover">
    <thead>
        <tr>
        	<th>#</th>
            <th>Documento</th>
            <th>Nombre Completo</th>
            <th>Solicitud Encuesta SISBÉN</th>
            <th>Puntaje SISBÉN V.3</th>
            <th>Ciudad SISBÉN V.3</th>
            <th>Continuidad Año 2016</th>
            <th>Oficio de Autorización</th>
            <th>Observaciones</th>
         </tr>
    </thead>
    <tbody>
    {% for beneficiario in beneficiarios %}
	{% set nombre = {beneficiario.primerNombre, beneficiario.segundoNombre, beneficiario.primerApellido, beneficiario.segundoApellido} %}
        <tr>
        	<td>{{ loop.index }}</td>
        	<td><input type="hidden" name="id_actafocalizacion_persona[]" value="{{ beneficiario.id_actafocalizacion_persona }}">{{ beneficiario.numDocumento }}</td>
            <td>{{ nombre|join(' ') }}</td>
            <td<?php echo $beneficiario->getsinonaDetail($beneficiario->encuestaSisben); ?>>{{ select("encuestaSisben[]", sinona, "value" : beneficiario.encuestaSisben, "class" : "form-control sinona required") }}</td>
            <td>{{ text_field("puntajeSisben[]", "parsley-range" : "[0,100]", "value" : beneficiario.puntajeSisben, "placeholder" : "Puntaje SISBEN V.3", "class" : "form-control") }}</td>
            <td>{{ text_field("ciudadSisben[]", "value" : beneficiario.ciudadSisben, "class" : "form-control") }}</td>
            <td<?php echo $beneficiario->getsinonaDetail($beneficiario->continuidad2015); ?>>{{ select("continuidad2015[]", sinona, "value" : beneficiario.continuidad2015, "class" : "form-control sinona required") }}</td>
            <td<?php echo $beneficiario->getsinonaDetail($beneficiario->oficioAutorizacion); ?>>{{ select("oficioAutorizacion[]", sinona, "value" : beneficiario.oficioAutorizacion, "class" : "form-control sinona required") }}</td>
            <td>{{ text_field("observacion[]", "value" : beneficiario.observacion, "class" : "form-control") }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{{ submit_button("Guardar", "class" : "btn btn-default pull-right") }}
</form>
<div class='clear'></div>
