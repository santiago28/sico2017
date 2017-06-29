
{{ content() }}
<h1>Editar Usuario</h1>
{{ link_to("ibc_usuario/", '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
{{ form("ibc_usuario/guardar/"~usuario.id_usuario, "method":"post", "class":"form-container form-horizontal", "id":"nuevo_form", "parsley-validate" : "") }}
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
	    	 {{ select("id_usuario_cargo", cargos, "class" : "form-control required") }}
		</div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="id_usuario_cargo">Auxiliar a cargo</label>
        <div class="col-sm-10">
        	{{ select("id_usuario_lider", usuarios_lider, "class" : "form-control required") }}
		</div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="id_componente">Componente</label>
        <div class="col-sm-10">
        	{{ select("id_componente", componentes, "class" : "form-control required") }}
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
        <label class="col-sm-2 control-label" for="password">Nueva Contraseña <a href="#" rel="tooltip" title="Deja este campo en blanco si no deseas cambiar la contraseña.">(?)</a> </label>
        <div class="col-sm-10">
               {{ password_field("password", "class" : "form-control", "id" : "password") }}
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" for="password_confirm">Confirmar Contraseña</label>
        <div class="col-sm-10">
               {{ password_field("password_confirm", "class" : "form-control", "id" : "password_confirm", "parsley-equalto" : "#password") }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="email">Foto de perfil</label>
        <div class="col-sm-10">
               	<div class="image-editor">
			        <input type="file" class="cropit-image-input">
			        <div class="cropit-image-preview cropit-image-loaded"></div>
			        <div class="image-size-label">
			          Redimensionar imagen
			        </div>
			        <input type="range" class="cropit-image-zoom-input">
			        <input type="hidden" name="image-data" class="hidden-image-data" />
			        {{ hidden_field("foto") }}
			    </div>
        </div>
    </div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
          <a class="btn btn-default submit">Guardar</a>
    </div>
</div>
</form>
