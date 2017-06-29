
{{ content() }}
<h1>Nuevo Periodo - Cronograma Hogares Comunitarios</h1>
{{ elements.getcronogramahcbMenuIbc() }}
{{ form("bc_hcb/crear_periodo", "method":"post", "class":"form-container form-horizontal", "parsley-validate" : "", "enctype" : "multipart/form-data") }}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="mes">Mes</label>
        <div class="col-sm-10">
        	{{ select("mes", meses, "class" : "form-control") }}
        </div>
    </div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
          {{ submit_button("Guardar", "class" : "btn btn-default") }}
    </div>
</div>
</form>
