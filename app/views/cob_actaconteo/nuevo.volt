{{ content() }}
{{ elements.getActamenu(acta) }}
<h1>Nueva Carga Actas - Planillas</h1>
{{ form("cob_actaconteo/crear/"~id_actaconteo, "method":"post", "class":"form-container form-horizontal", "parsley-validate" : "", "enctype" : "multipart/form-data") }}
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
<div class='clear'></div>
