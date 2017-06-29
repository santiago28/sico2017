{{ content() }}
<h1>Nuevo Empleado - Cronograma Hogares Comunitarios</h1>
{{ elements.getcronogramahcbMenu() }}
{{ form("bc_hcb/guardarempleado/", "method":"post", "parsley-validate" : "", "id" : "nuevoempleado_form", "class" : "form-container form-horizontal", "enctype" : "multipart/form-data" ) }}
<div class="form-group">
    <label class="col-sm-2 control-label" for="numDocumento">* Número de Documento</label>
    <div class="col-sm-10">
            {{ text_field("numDocumento", "class" : "form-control required") }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="primerNombre">* Primer Nombre</label>
    <div class="col-sm-10">
            {{ text_field("primerNombre", "class" : "form-control required") }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="segundoNombre">Segundo Nombre</label>
    <div class="col-sm-10">
            {{ text_field("segundoNombre", "class" : "form-control") }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="primerApellido">* Primer Apellido</label>
    <div class="col-sm-10">
            {{ text_field("primerApellido", "class" : "form-control required") }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="segundoApellido">Segundo Apellido</label>
    <div class="col-sm-10">
            {{ text_field("segundoApellido", "class" : "form-control") }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="cargo">* Cargo</label>
    <div class="col-sm-10">
            {{ select("cargo", cargo, "class" : "form-control required") }}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
          {{ submit_button("Guardar", "class" : "btn btn-default") }}
    </div>
</div>
</form>
<div class='clear'></div>
