
{{ content() }}
<h1>Nuevo Ajuste</h1>
{{ link_to("cob_ajuste/", '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
{{ form("cob_ajuste/nuevo", "method":"post", "class":"form-container form-horizontal", "parsley-validate" : "", "enctype" : "multipart/form-data") }}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="id_periodo">* Periodo</label>
        <div class="col-sm-10">
        	<select id="id_periodo" name="id_periodo" class="form-control">
			{% for periodo in periodos %}
					<option value="{{ periodo.id_periodo }}">{{ periodo.getFechaDetail() }} - {{ periodo.getTipoperiodoDetail() }}</option>
        	{% endfor  %}
			</select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="id_contrato">* Número de contrato</label>
        <div class="col-sm-10">
               {{ text_field("id_contrato", "class" : "form-control required", "parsley-type" : "number") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="numDocumento">* Número de documento</label>
        <div class="col-sm-10">
               {{ text_field("numDocumento", "class" : "form-control required", "parsley-type" : "number") }}
        </div>
    </div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
          {{ submit_button("Buscar", "class" : "btn btn-default") }}
    </div>
</div>
</form>
