
{{ content() }}
<h1>Cargar Periodo</h1>
<h2>Fecha de corte {{ fecha }}</h2>
{{ link_to("cob_periodo/index", '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
{{ form("cob_periodo/subir", "method":"post", "class":"form-container form-horizontal", "parsley-validate" : "", "enctype" : "multipart/form-data") }}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="fecha">Fecha</label>
        <div class="col-sm-10">
                {{ text_field("fecha", "type" : "date", "class" : "form-control tipo-fecha", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy") }}
        </div>
    </div>
	<div class="form-group imagen_imppnt">
	    <label for="nombre_usuario" class="col-sm-2 control-label">Archivo MAT</label>
	    <div class="col-sm-10">
	      <input type="file" name="files[]" multiple>
	    </div>
	</div>
	<div class="form-group imagen_imppnt">
	    <label for="nombre_usuario" class="col-sm-2 control-label">Archivo SEDES</label>
	    <div class="col-sm-10">
	      <input type="file" name="files[]" multiple>
	    </div>
	</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <input type="hidden" id="id_periodo" name="id_periodo" value="{{ id_periodo }}">
          <input type="submit" value="Send File(s)">
    </div>
</div>
</form>