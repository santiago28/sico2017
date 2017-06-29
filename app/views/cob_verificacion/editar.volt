
{{ content() }}
<h1>Editar Verificación</h1>
{{ link_to("cob_verificacion/index", '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
{{ form("cob_verificacion/guardar", "method":"post", "class":"form-container form-horizontal", "parsley-validate" : "") }}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="fecha">Fecha</label>
        <div class="col-sm-10">
                {{ text_field("fecha", "type" : "date", "class" : "form-control tipo-fecha", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy") }}
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" for="nombre">Título</label>
        <div class="col-sm-10">
                {{ text_field("nombre", "class" : "form-control") }}
        </div>
    </div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <input type="hidden" id="id_verificacion" name="id_verificacion" value="{{ id_verificacion }}">
          {{ submit_button("Guardar", "class" : "btn btn-default") }}
    </div>
</div>
</form>