
{{ content() }}
<h1>Nueva Verificación</h1>
{{ link_to("cob_verificacion/", '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
{{ form("cob_verificacion/crear", "method":"post", "class":"form-container form-horizontal", "parsley-validate" : "") }}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="tipo">Tipo de Verificacion</label>
        <div class="col-sm-10">
        	<select id="tipo" name="tipo" class="form-control">
					<option value="1">Revisión de Carpetas</option>
					<option value="2">Equipo de Cómputo</option>
					<option value="3">Telefónica</option>
          <option value="4">Talento Humano General</option>
          <option value="5">Focalización</option>
          <option value="6">Talento Humano Jardines</option>
			</select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="fecha">Fecha de Verificacion</label>
        <div class="col-sm-10">
                {{ text_field("fecha", "type" : "date", "class" : "form-control tipo-fecha", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="nombre">Título</label>
        <div class="col-sm-10">
                {{ text_field("nombre", "class" : "form-control", "placeholder" : "Título verificacion") }}
        </div>
    </div>
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
        <label class="col-sm-2 control-label" for="modalidad">Modalidades</label>
        <div class="col-sm-10">
        		{% for modalidad in modalidades %}
        			<label class="btn btn-primary active">
        			<input type="checkbox" name="modalidad[]" value="{{ modalidad.id_modalidad }}" autocomplete="off" checked> {{ modalidad.nombre }}
        			</label>
        		{% endfor  %}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="id_mes">Meses</label>
        <div class="col-sm-10">
        	<select id="id_mes" name="id_mes" class="form-control">
  			    {% for mes in meses %}
  					<option value="{{ mes.id_mes }}">{{ mes.id_mes }}</option>
          	{% endfor  %}
			     </select>
        </div>
    </div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
          {{ submit_button("Guardar", "class" : "btn btn-default") }}
    </div>
</div>
</form>
