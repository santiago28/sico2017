{{ content() }}
<div id="map-canvas"></div>
<h1>Contacto</h1>
<p><strong><i class="glyphicon glyphicon-time"></i> Horario de atención:</strong> Lunes a viernes 8:00 am - 11:45 am; 1:30 pm - 4:30 pm. <strong><i class="glyphicon glyphicon-earphone"></i> Teléfono:</strong> (57+4) 5121233. <br><strong><i class="glyphicon glyphicon-envelope"></i> Email:</strong> info@interventoriabuencomienzo.org</p>
          <p></p>
          <p></p>
{{ form("index/guardar", "method":"post", "class":"form-container form-horizontal", "parsley-validate" : "") }}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="nombre">*Nombre</label>
        <div class="col-sm-10">
               {{ text_field("nombre", "class" : "form-control required") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="email">*Email</label>
        <div class="col-sm-10">
               {{ text_field("email", "class" : "form-control required") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="mensaje">* Mensaje</label>
        <div class="col-sm-10">
                {{ text_area("mensaje", "rows" : "4", "class" : "form-control required") }}
        </div>
    </div>
	<div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	    	{{ submit_button("Generar", "class" : "btn btn-default") }}
	    </div>
	</div>
</form>