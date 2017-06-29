
{{ content() }}
<h1>Nueva Carga de Muestreo</h1>
{{ link_to("bc_carga/", '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
{{ form("bc_carga/crear", "method":"post", "class":"form-container form-horizontal", "parsley-validate" : "", "enctype" : "multipart/form-data") }}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="mes">* Mes</label>
        <div class="col-sm-10">
        	{{ select("mes", meses, "class" : "form-control") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="fechaReporte">* Fecha Reporte</label>
        <div class="col-sm-10">
        	{{ text_field("fechaReporte", "type" : "date", "class" : "form-control tipo-fecha", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Archivo Niños</label>
        <div class="col-sm-10">
            <input type="file" class="form-control" name="files[]" multiple>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label">Archivo Madres</label>
        <div class="col-sm-10">
            <input type="file" class="form-control" name="files[]" multiple>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Archivo Programación</label>
        <div class="col-sm-10">
            <input type="file" class="form-control" name="files[]" multiple>
        </div>
    </div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
          {{ submit_button("Guardar", "class" : "btn btn-default") }}
    </div>
</div>
</form>
