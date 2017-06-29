
{{ content() }}
<h1>Nuevo Permiso - Incidente</h1>
<a href='/sico/bc_permiso/nuevo/incidente' class='btn btn-primary regresar'><i class='glyphicon glyphicon-chevron-left'></i> Atrás</a><br><br>
<table class='table table-bordered table-hover'>
	<thead>
		<tr>
			<th>Contrato - Modalidad</th>
			<th>ID Sede - Nombre Sede</th>
			<th>Dirección</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{ sede.id_contrato }} - {{ sede.modalidad_nombre }}</td>
			<td>{{ sede.id_sede }} - {{ sede.sede_nombre }}</td>
			<td>{{ sede.sede_direccion }} ({{ sede.sede_barrio }})</td>
		</tr>
	</tbody>
</table>
<h3>3. Ingresa los campos del permiso</h3>
<div id="festivos" style="display:none"><?php echo $this->elements->festivos(); ?></div>
{{ form("bc_permiso/crear_incidente/"~id_sede_contrato, "method":"post", "class":"form-container form-horizontal", "parsley-validate" : "", "id" : "incidente_form", "enctype" : "multipart/form-data") }}
	<div class="form-group">
        <label class="col-sm-2 control-label" for="titulo">Motivo Permiso (25 caracteres máximo)</label>
        <div class="col-sm-10">
                {{ text_field("titulo", "maxlength" : "25", "parsley-maxlength" : "25", "class" : "form-control required") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="fecha">Fecha (dd/mm/aaaa)</label>
        <div class="col-sm-10">
                {{ text_field("fecha", "class" : "form-control tipo-fecha required", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="observaciones">Observaciones (150 caracteres máximo)</label>
        <div class="col-sm-10">
                {{ text_area("observaciones", "maxlength" : "150", "parsley-maxlength" : "150", "rows" : "4", "class" : "form-control required") }}
        </div>
    </div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
	    <input type="hidden" name="fecha_inicio" id="fecha_inicio" value="<?php echo date('d/m/Y'); ?>">
		<input type="hidden" name="fecha_fin" id="fecha_fin" value="<?php echo "01/01/" . date('Y',strtotime('+1 year')); ?>"">
          {{ submit_button("Guardar", "class" : "btn btn-default") }}
    </div>
</div>
</form>