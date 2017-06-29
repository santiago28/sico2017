
{{ content() }}
<div class="container form-signin form-container-login">

	<h2>Iniciar Sesión</h2>
	{{ form('session/start', 'role': 'form') }}
	{{ text_field('usuario', 'class': "form-control", 'placeholder' : "Usuario o Email") }}
	{{ password_field('password', 'class': "form-control", 'placeholder' : "Contraseña") }}
	{{ submit_button('Enviar', 'class': 'btn btn-lg btn-primary btn-block') }}
	</form>

</div>