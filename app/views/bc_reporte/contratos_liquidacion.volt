
{{ content() }}
<h1>Liquidación<br>
<h3>Escriba a continuación el número del contrato del cual desea obtener el reporte de certificación:</h3>
{{ form("bc_reporte/buscar_contratoliquidacion", "method":"post", "class":"form-container form-horizontal", "parsley-validate" : "", "enctype" : "multipart/form-data") }}
<div class="form-group">
    <label class="col-sm-2 control-label" for="id_contrato">* Número de contrato</label>
    <div class="col-sm-10">
           {{ text_field("id_contrato", "class" : "form-control required", "parsley-type" : "number") }}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
          {{ submit_button("Generar", "class" : "btn btn-default") }}
    </div>
</div>
</form>