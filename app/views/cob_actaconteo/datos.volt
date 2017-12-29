{{ content() }}
{{ elements.getActamenu(acta) }}
<table class="table table-bordered table-striped">
		<tbody>
            {% if(periodo_tipo != 2) %} <!-- Daniel Gallo 02/03/2017 -->
			<tr>
				<td>1. TOTAL DE NIÑOS Y NIÑAS QUE EFECTIVAMENTE ASISTIERON</td>
				<td>{{ asiste1 }}</td>
			</tr>
			<tr>
				<td>2. TOTAL DE NIÑOS Y NIÑAS AUSENTES CON EXCUSA FISICA VALIDA</td>
				<td>{{ asiste2 }}</td>
			</tr>
			<tr>
				<td>3. TOTAL DE NIÑOS Y NIÑAS AUSENTES CON EXCUSA TELEFONICA VALIDA</td>
				<td>{{ asiste3 }}</td>
			</tr>
			<tr>
				<td>4. TOTAL DE NIÑOS Y NIÑAS RETIRADOS ANTES DEL DIA DE CORTE DE PERIODO</td>
				<td>{{ asiste4 }}</td>
			</tr>
			<tr>
				<td>5. TOTAL DE NIÑOS Y NIÑAS RETIRADOS DESPUES DEL DIA DE CORTE DE PERIODO</td>
				<td>{{ asiste5 }}</td>
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
				<td><strong>TOTAL LISTADO DE NIÑOS Y NIÑAS REPORTADOS EN EL SIBC</strong></td>
				<td>{{ asistetotal }}</td>
			</tr>
			<tr>
				<td><strong>TOTAL NIÑOS ADICIONALES INGRESADOS</strong></td>
				<td>{{ asisteadicionales }}</td>
			</tr>
            {% else %}
            <tr>
				<td>1.1 ASISTE</td>
				<td>{{ asiste1 }}</td>
			</tr>
			<tr>
				<td>1.2 RETIRADO</td>
				<td>{{ asiste2 }}</td>
			</tr>
			<tr>
				<td>1.3 AUSENTE</td>
				<td>{{ asiste3 }}</td>
			</tr>
			<tr>
				<td>1.4 BENEFICIARIO CON EXCUSA VALIDA</td>
				<td>{{ asiste4 }}</td>
			</tr>
            <tr>
				<td>1.5 LLAMADA TELEFÓNICA PRECERTIFICADA</td>
				<td>{{ asiste5 }}</td>
			</tr>
            <tr>
				<td>1.6 LLAMADA TELEFÓNICA NO CERTIFICADA</td>
				<td>{{ asiste6 }}</td>
			</tr>
			<tr>
	<td>1.7 ENCUENTRO EN CASA</td>
	<td>{{ asiste7 }}</td>
</tr>
            {% endif %}
		</tbody>
	</table>
{{ form("cob_actaconteo/guardardatos/"~id_actaconteo, "method":"post", "class":"form-container form-horizontal", "parsley-validate" : "", "enctype" : "multipart/form-data") }}
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
    {% if(periodo_tipo != 2) %}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="nombreEncargado">* Nombre Encargado de la Sede</label>
        <div class="col-sm-10">
                {{ text_field("nombreEncargado", "class" : "form-control required") }}
        </div>
    </div>
    {% else %}
    {{ hidden_field("nombreEncargado", "value": "N/A") }}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="encuentroSede">* El encuentro se realizó en la sede matriculada</label>
        <div class="col-sm-10">
                {{ select("encuentroSede", sino, "class" : "form-control encuentroSede required") }}
        </div>
    </div>
    <div id="servicio-item" class="form-group hidden servicio">
        <label class="col-sm-2 control-label" for="nombreSede">* Nombre de la sede donde prestó el servicio</label>
        <div class="col-sm-10">
                {{ text_field("nombreSede", "placeholder" : "Nombre de la sede donde prestó el servicio", "class" : "form-control required hidden servicio", "disabled" : "disabled") }}
        </div>
    </div>
    <!--<div class="form-group">
        <label class="col-sm-2 control-label" for="mosaicoSanitario">* Cuenta con servicio sanitario, lavamanos, energía eléctrica y agua potable</label>
        <div class="col-sm-10">
                {{ select("mosaicoSanitario", sino, "class" : "form-control required") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="mosaicoSeguridad" placeholder="Plan de Ordenamiento Territorial">* Cuenta con condiciones minimas (POT)</label>
        <div class="col-sm-10">
                {{ select("mosaicoSeguridad", sino, "class" : "form-control required") }}
        </div>
    </div>-->
		<div class="form-group">
        <label class="col-sm-2 control-label" for="mosaicoEncuentro" placeholder="Plan de Ordenamiento Territorial">El encuentro se realizó</label>
        <div class="col-sm-10">
                {{ select("mosaicoEncuentro", tipo_encuentro, "class" : "form-control required") }}
        </div>
    </div>
		<div class="form-group">
        <label class="col-sm-2 control-label" for="gruposVisitados">* Cantidad de grupos visitados</label>
        <div class="col-sm-10">
                {{ text_field("gruposVisitados", "class" : "form-control required grupos") }}
        </div>
    </div>

    {% endif %}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="vallaClasificacion">* Valla de Identificación</label>
        <div class="col-sm-10">
                {{ select("vallaClasificacion", valla_sede, "class" : "form-control required") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="correccionDireccion">Corrección Dirección Sede</label>
        <div class="col-sm-10">
                {{ text_field("correccionDireccion", "class" : "form-control") }}
        </div>
    </div>
		{% if(periodo_tipo != 2) %}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="mosaicoFisico">* Cuenta con Registro Fotográfico Físico</label>
        <div class="col-sm-10">
                {{ select("mosaicoFisico", sino, "class" : "form-control required	") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="mosaicoDigital">* Cuenta con Registro Fotográfico Digital</label>
        <div class="col-sm-10">
                {{ select("mosaicoDigital", sino, "class" : "form-control required") }}
        </div>
    </div>
		{% endif %}
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
		{% if acta.id_modalidad == 12 %}
		<div class="form-group">
				<label class="col-sm-2 control-label" for="estadoVisita">* Estado de la visita</label>
				<div class="col-sm-10">
								{{ select("estadoVisita", estadoVisita, "class" : "form-control required") }}
				</div>
		</div>
        <div class="form-group">
                <label class="col-sm-2 control-label" for="numeroEncuentos">* Número de Encuentros</label>
                <div class="col-sm-10">
                                {{ select("numeroEncuentos", numeroEncuentos, "class" : "form-control required") }}
                </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="gestionTelefonica">Gestión Telefonica</label>
            <div class="col-sm-10">
                    {{ text_area("gestionTelefonica", "rows" : "4", "class" : "form-control") }}
            </div>
        </div>
    {% endif %}
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
          {{ submit_button("Guardar", "class" : "btn btn-default") }}
    </div>
</div>
</form>
<script>
setTimeout(function(){
	$(document).ready(function(){
		$("#fecha").datepicker({
      language: 'es',
      autoclose: true,
    });
		document.getElementsByClassName("grupos")[0].setAttribute("type", "number");
	});
	},1000);
</script>
