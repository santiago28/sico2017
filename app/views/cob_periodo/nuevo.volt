
{{ content() }}
<h1>Nuevo Periodo</h1>
{{ link_to("cob_periodo/", '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
{{ form("cob_periodo/crear", "method":"post", "class":"form-container form-horizontal", "parsley-validate" : "") }}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="tipo">Tipo Periodo</label>
        <div class="col-sm-10">
        	<select id="tipo" name="tipo" class="form-control">
					<option value="1">Conteo General</option>
					<option value="2">Entorno Familiar</option>
					<option value="3">Entorno Comunitario</option>
					<option value="4">Entorno Comunitario Itinerante</option>
					<option value="5">Jardines Infantiles</option>
			</select>
		</div>
    </div>
	
	<div class="form-group" id="modalidad">
			<label class="col-sm-2 control-label" for="tipo">Modalidad</label>
			<div class="col-sm-10">
				<div class="radio-inline">
				  <label><input type="radio" name="descripcion" value="INSTITUCIONAL 8 HORAS">I8H</label>
				</div>
				<div class="radio-inline">
				  <label><input type="radio" class="observacion" name="descripcion" value="ENTORNO FAMILIAR">EF</label>
				</div>
				<div class="radio-inline">
				  <label><input type="radio" class="observacion" name="descripcion" value="LUDOTEKAS">LDK</label>
				</div>
				<div class="radio-inline">
				  <label><input type="radio" class="observacion" name="descripcion" value="JARDINES INFANTILES">JI</label>
				</div>
				<div class="radio-inline">
				  <label><input type="radio" class="observacion" name="descripcion" value="PRESUPUESTO PARTICIPATIVO">PP</label>
				</div>
				<div class="radio-inline">
				  <label><input type="radio" class="observacion" name="descripcion" value="SALA CUNAS 8 HORAS">SC8H</label>
				</div>
			</div>
		</div>

		<div class="form-group" id="prestador">
			<label class="col-sm-2 control-label" for="tipo">Prestador</label>
			<div class="col-sm-10">
				<div class="radio-inline">
				  <label><input type="radio" class="observacion" name="descripcion" value="CORINGE Y PRESENCIA">Coringe y Presencia</label>
				</div>
				<div class="radio-inline">
				  <label><input type="radio" class="observacion" name="descripcion" value="METROSALUD">Metrosalud</label>
				</div>
			</div>
		</div>			
	
    <div class="form-group">
        <label class="col-sm-2 control-label" for="fecha">Fecha</label>
        <div class="col-sm-10">
                {{ text_field("fecha", "type" : "date", "class" : "form-control tipo-fecha", "placeholder" : "dd/mm/aaaa", "parsley-type" : "dateIso", "data-date-format" : "dd/mm/yyyy") }}
        </div>
    </div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
          {{ submit_button("Guardar", "class" : "btn btn-default") }}
    </div>
</div>
</form>
<script>
	setTimeout(function(){
		$("#prestador").css("display", "none");
		$("#modalidad").css("display", "block");
		
		$("#tipo").change(function(){
			$(".observacion").removeAttr('checked');
			var tipo = $(this).val();
			if(tipo == 1){
				$("#modalidad").css("display", "block");
				$("#prestador").css("display", "none");
			}else{
				if(tipo == 2)
				{
					$("#prestador").css("display", "block");
					$("#modalidad").css("display", "none");
				}else{
					$("#prestador").css("display", "none");
					$("#modalidad").css("display", "none");
				}
			}
		});
	});
</script>
