{{ content() }}
{{ elements.getActamenu(acta) }}
{{ form("cob_actaconteo/guardarseguimientoitinerante/"~id_actaconteo, "method":"post", "parsley-validate" : "", "id" : "seguimientoitinerante_form", "enctype" : "multipart/form-data" ) }}
<table class="table table-bordered table-hover" id="{{ id_actaconteo }}">
    <thead>
        <tr>
        	<th>#</th>
            <th>Fecha</th>
            <th>Hora Inicio</th>
            <th>Hora Fin</th>
            <th>Nombres y Apellidos profesional BC</th>
            <th>Documento profesional BC</th>
            <th>Cargo profesional BC</th>
            <th>Tema abordado encuentro</th>
						<th>Necesidades, expectativas, intereses</th>
						<th>Número de niños participantes</th>
            <th>X</th>
         </tr>
    </thead>
    <tbody>
		<?php $i = 1; ?>
    {% for seguimiento in seguimiento %}
    <?php
		$fecha = $this->conversiones->fecha(2, $seguimiento->fecha); ?>
    	<tr>
        	<td><span class="number">{{ loop.index }}</span></td>
        	<td>{{ text_field("fecha[]", "disabled" : "disabled", "value" : fecha, "type" : "date", "class" : "form-control tipo-fecha required fecha", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy") }}</td>
        	<td>{{ text_field("horaInicio[]", "disabled" : "disabled", "value" : seguimiento.horaInicio, "class" : "form-control required time start") }}</td>
        	<td>{{ text_field("horaFin[]", "disabled" : "disabled", "value" : seguimiento.horaFin, "class" : "form-control required time end") }}</td>
        	<td>{{ text_field("nombre[]", "disabled" : "disabled", "value" : seguimiento.nombre, "class" : "form-control required") }}</td>
        	<td>{{ text_field("numDocumento[]", "disabled" : "disabled", "parsley-type" : "number", "value" : seguimiento.numDocumento, "class" : "form-control numDocumento required") }}<div class="error_documento"></div></td>
					<td>{{ select("cargo[]", cargo, "disabled" : "disabled", "value" : seguimiento.cargo, "class" : "form-control required") }}</td>
					<td>{{ text_area("temaEncuentro[]", "maxlength" : "500", "disabled" : "disabled", "value" : seguimiento.temaEncuentro, "rows" : "3", "class" : "form-control required") }}</td>
					<td>{{ text_area("necesidades[]",  "maxlength" : "500", "disabled" : "disabled", "value" : seguimiento.necesidades, "rows" : "3", "class" : "form-control required") }}</td>
					<td>{{ text_field("participantes[]", "disabled" : "disabled", "parsley-type" : "number", "value" : seguimiento.participantes, "class" : "form-control required") }}</td>
					<td style="text-align:center;"><a id='{{ seguimiento.id_actaconteo_empleadoitinerante }}' class='btn btn-default eliminar_guardado'><i class='glyphicon glyphicon-remove'></i></a><br><a class='btn btn-default editar_guardado'><i class='glyphicon glyphicon-edit'></i></a></td>
      </tr>
		<?php $i++; ?>
    {% endfor %}
		<?php for ($j = $i; $j <= 12; $j++) { ?>
        <tr>
        	<td><span class="number"><?php echo $j; ?></span></td>
					<td>{{ text_field("fecha[]","type" : "date", "disabled" : "disabled", "class" : "form-control tipo-fecha required fecha", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy") }}<a class="btn btn-primary btn-sm editar">Editar</a></td>
        	<td>{{ text_field("horaInicio[]", "disabled" : "disabled", "class" : "form-control required time start") }}</td>
        	<td>{{ text_field("horaFin[]", "disabled" : "disabled", "class" : "form-control required time end") }}</td>
        	<td>{{ text_field("nombre[]", "disabled" : "disabled", "class" : "form-control required") }}</td>
        	<td>{{ text_field("numDocumento[]", "disabled" : "disabled", "class" : "form-control required") }}<div class="error_documento"></div></td>
					<td>{{ select("cargo[]", cargo, "disabled" : "disabled", "class" : "form-control required") }}</td>
					<td>{{ text_area("temaEncuentro[]", "disabled" : "disabled", "rows" : "3", "class" : "form-control required") }}</td>
					<td>{{ text_area("necesidades[]", "disabled" : "disabled", "rows" : "3", "class" : "form-control required") }}</td>
					<td>{{ text_field("participantes[]", "disabled" : "disabled", "class" : "form-control required") }}</td>
					<td></td>
				</tr>
    <?php } ?>
    </tbody>
</table>
<div class="row container" style="padding-top: 10px;">
		<input type="hidden" name="eliminar_empleados" id="eliminar_empleados">
  	<a class="btn btn-default pull-right submit_empleados">Guardar</a>
</div>
</form>
<div class='clear'></div>
