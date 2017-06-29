{{ content() }}
{{ elements.getActathmenu(acta) }}
{{ form("cob_actath/guardartalentohumano/"~acta.id_acta, "method":"post", "parsley-validate" : "", "id" : "talentohumano_form") }}
<table class="table table-bordered table-hover">
    <thead>
        <tr>
        	<th>#</th>
            <th>Documento</th>
            <th>Nombre Completo</th>
            <th>Cédula Coincide</th>
            <th>Nombre Coincide</th>
            <th>Formación Académica Coincide</th>
            <th>Cargo Coincide</th>
            <th>Tipo Contrato Coincide</th>
            <th>Salario Coincide</th>
            <th>Dedicación Coincide</th>
            <th>Fecha Ingreso Coincide</th>
            <th>Fecha Retiro</th>
            <th>Asistencia</th>
            <th>Observación</th>
         </tr>
    </thead>
    <tbody>
    {% for talento in talentohumano %}
	{% set nombre = {talento.primerNombre, talento.segundoNombre, talento.primerApellido, talento.segundoApellido} %}
        <tr>
        	<td>{{ loop.index }}</td>
        	<td><input type="hidden" name="id_actath_persona[]" value="{{ talento.id_actath_persona }}">{{ talento.numDocumento }}</td>
            <td>{{ nombre|join(' ') }}</td>
            <td<?php echo $talento->getsinonareDetail($talento->cedulaCoincide); ?>>{{ select("cedulaCoincide[]", sinonare, "value" : talento.cedulaCoincide, "class" : "form-control sinonare required") }}</td>
            <td<?php echo $talento->getsinonareDetail($talento->nombreCoincide); ?>>{{ select("nombreCoincide[]", sinonare, "value" : talento.nombreCoincide, "class" : "form-control sinonare required") }}</td>
            <td<?php echo $talento->getsinonareDetail($talento->formacionacademicaCoincide); ?>>{{ select("formacionacademicaCoincide[]", sinonare, "value" : talento.formacionacademicaCoincide, "class" : "form-control sinonare required") }}</td>
            <td<?php echo $talento->getsinonareDetail($talento->cargoCoincide); ?>>{{ select("cargoCoincide[]", sinonare, "value" : talento.cargoCoincide, "class" : "form-control sinonare required") }}</td>
            <td<?php echo $talento->getsinonareDetail($talento->tipocontratoCoincide); ?>>{{ select("tipocontratoCoincide[]", sinonare, "value" : talento.tipocontratoCoincide, "class" : "form-control sinonare required") }}</td>
            <td<?php echo $talento->getsinonareDetail($talento->salarioCoincide); ?>>{{ select("salarioCoincide[]", sinonare, "value" : talento.salarioCoincide, "class" : "form-control sinonare required") }}</td>
            <td<?php echo $talento->getsinonareDetail($talento->dedicacionCoincide); ?>>{{ select("dedicacionCoincide[]", sinonare, "value" : talento.dedicacionCoincide, "class" : "form-control sinonare required") }}</td>
            <td<?php echo $talento->getsinonareDetail($talento->fechaingresoCoincide); ?>>{{ select("fechaingresoCoincide[]", sinonare, "value" : talento.fechaingresoCoincide, "class" : "form-control sinonare required") }}</td>
            <td>{{ text_field("fechaRetiro[]", "type" : "date", "class" : "form-control tipo-fecha", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy", "value": talento.getFechaRetiro()) }}</td>
            <td>{{ select("asistencia[]", asistencia, "value" : talento.asistencia, "class" : "form-control asistencia required") }}</td>
            <td>{{ text_field("observacion[]", "value" : talento.observacion, "class" : "form-control observacion") }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{{ submit_button("Guardar", "class" : "btn btn-default pull-right") }}
</form>
<div class='clear'></div>
