{{ content() }}
{{ elements.getActathmenu(acta) }}
<table id ="talentohumano_lista" class="hidden">
  <tbody>
{% for talento in talentohumano %}
{% set nombre = {talento.primerNombre, talento.segundoNombre, talento.primerApellido, talento.segundoApellido} %}
      <tr id="{{ talento.numDocumento }}">
        <td><span class="number"></span></td>
        <td><input type="hidden" name="id_actath_persona[]" value="{{ talento.id_actath_persona }}"><input type="hidden" name="numDocumento[]" value="{{ talento.numDocumento }}">{{ talento.numDocumento }}</td>
          <td>{{ nombre|join(' ') }}</td>
          <td>{{ select("cedulaCoincide[]", sinonare, "class" : "form-control sinonare required") }}</td>
          <td>{{ select("nombreCoincide[]", sinonare, "class" : "form-control sinonare required") }}</td>
          <td>{{ select("formacionacademicaCoincide[]", sinonare, "class" : "form-control sinonare required") }}</td>
          <td>{{ select("cargoCoincide[]", sinonare, "class" : "form-control sinonare required") }}</td>
          <td>{{ select("tipocontratoCoincide[]", sinonare, "class" : "form-control sinonare required") }}</td>
          <td>{{ select("salarioCoincide[]", sinonare, "class" : "form-control sinonare required") }}</td>
          <td>{{ select("dedicacionCoincide[]", sinonare, "class" : "form-control sinonare required") }}</td>
          <td>{{ select("fechaingresoCoincide[]", sinonare, "class" : "form-control sinonare required") }}</td>
          <td>{{ text_field("fechaRetiro[]", "type" : "date", "class" : "form-control tipo-fecha", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy") }}</td>
          <td>{{ select("asistencia[]", asistencia, "class" : "form-control asistencia required") }}</td>
          <td>{{ text_field("observacion[]", "class" : "form-control observacion") }}</td>
      </tr>
{% endfor %}
  </tbody>
</table>
{{ form("cob_actath/guardaradicionales_listado/"~acta.id_acta, "method":"post", "parsley-validate" : "", "id" : "talentohumano_form") }}
<table class="table table-bordered table-hover" id="adicionales_listado">
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
      {% for talento in adicionales_listado %}
      {% set nombre = {talento.CobActathPersona.primerNombre, talento.CobActathPersona.segundoNombre, talento.CobActathPersona.primerApellido, talento.CobActathPersona.segundoApellido} %}
            <tr id="{{ talento.numDocumento }}">
              <td><span class="number"></span></td>
              <td><input type="hidden" name="id_actath_persona[]" value="{{ talento.id_actath_persona }}"><input type="hidden" name="numDocumento[]" value="{{ talento.numDocumento }}">{{ talento.numDocumento }}</td>
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
<div class="row">
  <div class="col-lg-6">
      <div class="input-group">
        <input type="text" class="form-control input_agregar_ced" placeholder="Agregar por cédula...">
        <span class="input-group-btn">
          <button class="btn btn-primary agregar_cedula" type="button">Agregar</button>
        </span>
      </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
  <div class="col-lg-4 pull-right">
      {{ submit_button("Guardar", "class" : "btn btn-default pull-right") }}
  </div><!-- /.col-lg-6 -->
</div>
</form>
<div class="error"></div>
<div class='clear'></div>
