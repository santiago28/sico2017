
{{ content() }}
{{ elements.getMensajeMenu() }}
{% if (mensaje) %}
	<div class="mensaje">
   		<div class="header">
		  <div class="foto">
		    <a href="/sico/ibc_usuario/ver/{{ mensaje.IbcUsuario.id_usuario }}"><img src="{{ mensaje.IbcUsuario.foto }}" width="40px" height="40px"></a>
		  </div>
		  <div>
		  	<h3 style="margin: 0px;">{{ mensaje.IbcUsuario.nombre }}</h3>
   			<div class="info_anuncio"><?php $date = date_create($mensaje->fecha); ?><i class="fa fa-calendar"></i> <?php echo date_format($date, 'd/m/Y'); ?> <i class="fa fa-clock-o"></i> <?php echo date_format($date, 'G:ia'); ?> <span class="label label-success">{{ mensaje.IbcMensajeDestinatario.nombre }}</span></div>
		  </div>
		</div>
   		<div class="contenido">{{ mensaje.mensaje }}</div>
	</div>
	<div class="comentarios">
		{% if (mensaje.IbcMensajeComentario|length > 0) %}
		{% for comentario in mensaje.IbcMensajeComentario %}
	   		<div class="comentario">
	   			<div class="foto"><a href="/sico/ibc_usuario/ver/{{ comentario.IbcUsuario.id_usuario }}"><img src="{{ comentario.IbcUsuario.foto }}" width="25px" height="25px"></a></div>
	   			<div class="texto"><a href="/sico/ibc_usuario/ver/{{ comentario.IbcUsuario.id_usuario }}">{{ comentario.IbcUsuario.nombre }}:</a> {{ comentario.comentario }}<div class='fecha'><?php $date = date_create($mensaje->fecha); ?><?php echo date_format($date, 'd/m/Y'); ?> <?php echo date_format($date, 'G:ia'); ?></div></div>
	   		</div>
	   	{% endfor %}
		{% endif %}
		{{ form("ibc_mensaje/comentario/"~mensaje.id_mensaje~"/mensaje", "method":"post", "parsley-validate" : "") }}
   		<div class="input-group">
	      {{ text_area("comentario", "rows" : "1", "class" : "form-control required", "placeholder" : "Escriba aquí su comentario...") }}
	      <span class="input-group-btn">
	        {{ submit_button("Guardar", "class" : "btn btn-primary") }}
	      </span>
	    </div>
   		</form>
	</div>
{% endif %}