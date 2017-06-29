{{ content() }}
{{ elements.getActametrosaludmenu(acta) }}
<table class="table table-bordered table-striped">
		<tbody>
			<tr>
				<td>1. TOTAL DE NIÑOS Y NIÑAS QUE EFECTIVAMENTE ASISTIERON</td>
				<td>{{ asiste1 }}</td>
			</tr>
			<tr>
				<td>4. TOTAL DE NIÑOS Y NIÑAS RETIRADOS</td>
				<td>{{ asiste4 }}</td>
			</tr>
			<tr>
				<td>6. TOTAL DE NIÑOS Y NIÑAS AUSENTES QUE NO PRESENTAN EXCUSA EL DIA DEL REPORTE</td>
				<td>{{ asiste6 }}</td>
			</tr>
			<tr>
				<td>7. TOTAL DE NIÑOS Y NIÑAS CON EXCUSA MEDICA MAYOR O IGUAL A 15 DÍAS</td>
				<td>{{ asiste7 }}</td>
			</tr>
			<tr>
				<td>8. TOTAL DE NIÑOS Y NIÑAS CON EXCUSA MEDICA MENOR A 15 DÍAS</td>
				<td>{{ asiste8 }}</td>
			</tr>
			<tr>
				<td><strong>TOTAL LISTADO DE NIÑOS Y NIÑAS REPORTADOS EN EL SISTEMA DE INFORMACIÓN DE METROSALUD</strong></td>
				<td>{{ asistetotal }}</td>
			</tr>
		</tbody>
	</table>
{{ form("cob_actamuestreo/guardardatos/"~id_actamuestreo, "method":"post", "class":"form-container form-horizontal", "parsley-validate" : "", "enctype" : "multipart/form-data") }}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="fecha">* Fecha Interventoría</label>
        <div class="col-sm-10">
                {{ text_field("fecha", "type" : "date", "class" : "form-control tipo-fecha required", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="horaInicio">* Hora Inicio</label>
        <div class="col-sm-10">
                {{ text_field("horaInicio", "placeholder": "Ej: 08:30 am", "class" : "form-control required") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="horaFin">* Hora Fin</label>
        <div class="col-sm-10">
                {{ text_field("horaFin", "placeholder": "Ej: 09:00 am", "class" : "form-control required") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="nombreEncargado">* Nombre Encargado de la Sede</label>
        <div class="col-sm-10">
                {{ text_field("nombreEncargado", "class" : "form-control required") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="pendonClasificacion">* Pendón de Identificación</label>
        <div class="col-sm-10">
                {{ select("pendonClasificacion", valla_sede, "class" : "form-control required") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="correccionDireccion">Corrección Dirección Sede</label>
        <div class="col-sm-10">
                {{ text_field("correccionDireccion", "class" : "form-control") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="instalacionesDomiciliarias">* Servicios Domiciliarios</label>
        <div class="col-sm-10">
                {{ select("instalacionesDomiciliarias", sinona, "class" : "form-control required") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="condicionesSeguridad">* Condiciones de Seguridad</label>
        <div class="col-sm-10">
                {{ select("condicionesSeguridad", sinona, "class" : "form-control required") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="observacionUsuario">Observación Interventor</label>
        <div class="col-sm-10">
                {{ text_area("observacionUsuario", "rows" : "4", "class" : "form-control") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="observacionEncargado">Observación Encargado Sede</label>
        <div class="col-sm-10">
                {{ text_area("observacionEncargado", "rows" : "4", "class" : "form-control") }}
        </div>
    </div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
          {{ submit_button("Guardar", "class" : "btn btn-default") }}
    </div>
</div>
</form>