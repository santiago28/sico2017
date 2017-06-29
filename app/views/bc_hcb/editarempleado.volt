{{ content() }}
<h1>Editar Empleado - Cronograma Hogares Comunitarios</h1>
{{ elements.getcronogramahcbMenu() }}
{{ form("bc_hcb/guardareditarempleado/"~empleado.id_hcbempleado, "method":"post", "parsley-validate" : "", "id" : "nuevoempleado_form", "class" : "form-container form-horizontal", "enctype" : "multipart/form-data" ) }}
<div class="form-group">
    <label class="col-sm-2 control-label" for="numDocumento">* Número de Documento</label>
    <div class="col-sm-10">
            {{ text_field("numDocumento", "class" : "form-control required", "value" : empleado.numDocumento) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="primerNombre">* Primer Nombre</label>
    <div class="col-sm-10">
            {{ text_field("primerNombre", "class" : "form-control required",  "value" : empleado.primerNombre) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="segundoNombre">Segundo Nombre</label>
    <div class="col-sm-10">
            {{ text_field("segundoNombre", "class" : "form-control",  "value" : empleado.segundoNombre) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="primerApellido">* Primer Apellido</label>
    <div class="col-sm-10">
            {{ text_field("primerApellido", "class" : "form-control required", "value" : empleado.primerApellido) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="segundoApellido">Segundo Apellido</label>
    <div class="col-sm-10">
            {{ text_field("segundoApellido", "class" : "form-control",  "value" : empleado.segundoApellido) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="cargo">* Cargo</label>
    <div class="col-sm-10">
            {{ select("cargo", cargo, "class" : "form-control required", "value" : empleado.id_cargo) }}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
          {{ submit_button("Guardar", "class" : "btn btn-default") }}
    </div>
</div>
</form>
<div class='clear'></div>
