{{ content() }}
{{ elements.getActathmenu(acta) }}
{{ form("cob_actath/guardardatos/"~acta.id_acta, "method":"post", "class":"form-container form-horizontal", "parsley-validate" : "", "enctype" : "multipart/form-data") }}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="fecha">* Fecha Interventoría</label>
        <div class="col-sm-10">
                {{ text_field("fecha", "type" : "date", "class" : "form-control tipo-fecha required", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="horaInicio">* Hora Inicio</label>
        <div class="col-sm-10">
                {{ text_field("horaInicio", "placeholder": "Ej: 08:30 am", "class" : "form-control required") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="horaFin">* Hora Fin</label>
        <div class="col-sm-10">
                {{ text_field("horaFin", "placeholder": "Ej: 09:00 am", "class" : "form-control required") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="nombreEncargado">* Nombre Encargado de la Sede</label>
        <div class="col-sm-10">
                {{ text_field("nombreEncargado", "class" : "form-control required") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="observacionUsuario">Observación Interventor</label>
        <div class="col-sm-10">
                {{ text_area("observacionUsuario", "rows" : "4", "class" : "form-control") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="observacionEncargado">Observación Encargado Sede</label>
        <div class="col-sm-10">
                {{ text_area("observacionEncargado", "rows" : "4", "class" : "form-control") }}
        </div>
    </div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
          {{ submit_button("Guardar", "class" : "btn btn-default") }}
    </div>
</div>
</form>
