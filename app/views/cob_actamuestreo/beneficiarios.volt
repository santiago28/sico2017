{{ content() }}
{{ elements.getActametrosaludmenu(acta) }}
{{ form("cob_actamuestreo/guardarbeneficiarios/"~id_actamuestreo, "method":"post", "parsley-validate" : "", "id" : "beneficiarios_form") }}
<table class="table table-bordered table-hover">
    <thead>
        <tr>
        	<th>#</th>
            <th>Documento</th>
            <th>Nombre Completo</th>
            <th>Grupo</th>
            <th>Ciclo Vital</th>
            <th>Compl Alimentario</th>
            <th>Asistencia</th>
         </tr>
    </thead>
    <tbody>
    {% for beneficiario in beneficiarios %}  
	{% set nombre = {beneficiario.primerNombre, beneficiario.segundoNombre, beneficiario.primerApellido, beneficiario.segundoApellido} %}
        <tr<?php echo $beneficiario->getAsistenciaDetail(); ?>>
        	<td>{{ loop.index }}</td>
        	<td>{{ beneficiario.numDocumento }}</td>
            <td>{{ nombre|join(' ') }}</td>
            <td>{{ beneficiario.grupo }}</td>
            <td>{{ select("cicloVital[]", ciclovital, "value" : beneficiario.cicloVital, "class" : "form-control ciclovital required") }}</td>
            <td>{{ select("complAlimientario[]", sinona, "value" : beneficiario.complAlimientario, "class" : "form-control alimentario required") }}</td>
            <td><input type="hidden" name="id_actamuestreo_persona[]" value="{{ beneficiario.id_actamuestreo_persona }}">{{ select("asistencia[]", asistencia, "value" : beneficiario.asistencia, "class" : "form-control asistencia required") }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{{ submit_button("Guardar", "class" : "btn btn-default pull-right") }}
</form>
<div class='clear'></div>