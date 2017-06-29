
{{ content() }}
<h1>Nuevo Usuario</h1>
{{ link_to("ibc_usuario/", '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
{{ form("ibc_usuario/crear", "method":"post", "class":"form-container form-horizontal", "id":"nuevo_form", "parsley-validate" : "", "enctype" : "multipart/form-data") }}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="email">* Email</label>
        <div class="col-sm-10">
               {{ email_field("email", "class" : "form-control required") }}
        </div>
    </div>
   <div class="form-group">
        <label class="col-sm-2 control-label" for="usuario">* Nombre de usuario</label>
        <div class="col-sm-10">
               {{ text_field("usuario", "class" : "form-control required") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="nombre">* Nombre completo</label>
        <div class="col-sm-10">
               {{ text_field("nombre", "class" : "form-control required") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="id_usuario_cargo">Cargo</label>
        <div class="col-sm-10">
	    	<select id="id_usuario_cargo" name="id_usuario_cargo" class="form-control required">
			{% for cargo in cargos %}
					<option value="{{ cargo.id_usuario_cargo }}">{{ cargo.nombre }}</option>
	    	{% endfor  %}
			</select>
		</div>
    </div>
    <div class="form-group hide">
        <label class="col-sm-2 control-label" for="id_usuario_cargo">Auxiliar a cargo</label>
        <div class="col-sm-10">
	    	<select id="id_usuario_lider" name="id_usuario_lider" class="form-control required" disabled="disabled">
			{% for usuario_lider in usuarios_lider %}
					<option value="{{ usuario_lider.id_usuario }}">{{ usuario_lider.nombre }}</option>
	    	{% endfor  %}
			</select>
		</div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="id_componente">Componente</label>
        <div class="col-sm-10">
	    	<select id="id_componente" name="id_componente" class="form-control required">
			{% for componente in componentes %}
					<option value="{{ componente.id_componente }}">{{ componente.nombre }}</option>
	    	{% endfor  %}
			</select>
		</div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="telefono">* Teléfono</label>
        <div class="col-sm-10">
               {{ text_field("telefono", "class" : "form-control required", "parsley-type" : "number") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="celular">* Celular</label>
        <div class="col-sm-10">
               {{ text_field("celular", "class" : "form-control required", "parsley-type" : "number") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="password">*Contraseña</label>
        <div class="col-sm-10">
               {{ password_field("password", "class" : "form-control required", "id" : "password") }}
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" for="password_confirm">* Confirmar Contraseña</label>
        <div class="col-sm-10">
               {{ password_field("password_confirm", "class" : "form-control required", "id" : "password_confirm", "parsley-equalto" : "#password") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="email">Foto de perfil</label>
        <div class="col-sm-10">
               	<div class="image-editor">
			        <input type="file" class="cropit-image-input">
			        <div class="cropit-image-preview"></div>
			        <div class="image-size-label">
			          Redimensionar imagen
			        </div>
			        <input type="range" class="cropit-image-zoom-input">
			        <input type="hidden" name="image-data" class="hidden-image-data" />
			    </div>
        </div>
    </div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    	<a class="btn btn-default submit">Guardar</a>
    </div>
</div>
</form>
