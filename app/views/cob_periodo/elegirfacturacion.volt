
{{ content() }}
<h1>Elegir Facturación para periodo </h1>
{{ link_to("cob_periodo/ver/"~id_periodo, '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
{{ form("cob_periodo/elegirfacturacionguardar/"~id_periodo, "method":"post", "class":"form-container form-horizontal", "parsley-validate" : "") }}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="carga">Carga</label>
        <div class="col-sm-10">
        	<select id="carga" name="carga" class="form-control">
			{% for carga in cargas %}
					<option value="{{ carga.id_carga }}">{{ carga.mes }} {{ carga.fecha }} {{ carga.nombreMat }}</option>
        	{% endfor  %}
			</select>
        </div>
    </div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
          {{ submit_button("Generar", "class" : "btn btn-default") }}
    </div>
</div>
</form>