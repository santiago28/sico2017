
{{ content() }}
<h1>Nueva Carga Individual</h1>
{{ link_to("bc_carga/", '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
{{ form("bc_carga/crearindividual", "method":"post", "class":"form-container form-horizontal", "parsley-validate" : "", "enctype" : "multipart/form-data") }}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="mes">Mes</label>
        <div class="col-sm-10">
        	{{ select("mes", meses, "class" : "form-control") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Archivo MAT</label>
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
