
{{ content() }}
<!-- Modal -->
<div class="modal fade" id="agregar_usuarios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Agregar Usuarios</h4>
      </div>
      <div class="modal-body">
    <table id="lista_usuarios" class="table table-bordered table-hover">
    <thead>
        <tr>
        	<th><i class="glyphicon glyphicon-remove uncheck" style="text-align: center; cursor:pointer; width: 100%"></i></th>
            <th>Usuario
            	<input autocomplete='off' class='filter form-control input-sm' name='usuario' data-col='usuario'/>
            </th>
            <th>Nombre
            	<input autocomplete='off' class='filter form-control input-sm' name='nombre' data-col='nombre'/>
            </th>
            <th>Componente
            	<input autocomplete='off' class='filter form-control input-sm' name='componente' data-col='componente'/>
            </th>
            <th>Cargo
            	<input autocomplete='off' class='filter form-control input-sm' name='cargo' data-col='cargo'/>
            </th>
         </tr>
    </thead>
    <tbody>
    {% for usuario in usuarios %}
        <tr>
        	<td><input type="checkbox" class="usuario_check" data-usuario="{{ usuario.usuario }}" id="{{ usuario.id_usuario }}" value="{{ usuario.id_usuario }}"></td>
            <td>{{ usuario.usuario }}</td>
            <td>{{ usuario.nombre }}</td>
            <td>{{ usuario.IbcComponente.nombre }}</td>
            <td>{{ usuario.IbcUsuarioCargo.nombre }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" data-dismiss="modal" id="btn_agregar">Agregar</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{ form("ibc_mensaje/crear/", "method":"post", "parsley-validate" : "") }}
{{ text_area("mensaje", "rows" : "3", "class" : "form-control required", "placeholder" : "Escriba aquí su mensaje...") }}
<div id="cont-users" class="pull-right"></div><div class="clear"></div>
<div class="input-group col-lg-4 pull-right">
	{{ anuncio }}
  	{{ select("destinatario", destinatarios, "class" : "form-control pull-right required") }}
    <span class="input-group-btn">
    	{{ submit_button("Enviar", "class" : "btn btn-primary") }}
   	</span>
</div>
</form>
<div class="clear" style="margin-bottom: 10px"></div>
{{ elements.getMensajeMenu() }}
{% if (anuncios is empty) %}
	<div class="alert alert-info">Actualmente no se ha publicado ningún mensaje.</div>
{% else %}
	{% for mensaje in anuncios %}
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
		<a class="cant-comentarios" data-toggle="collapse" data-target="#comentarios{{ mensaje.id_mensaje }}" aria-expanded="false" aria-controls="#comentarios{{ mensaje.id_mensaje }}">
		  <i class="glyphicon glyphicon-comment"></i> {{ mensaje.IbcMensajeComentario|length }} comentarios
		</a>
		<div class="collapse" id="comentarios{{ mensaje.id_mensaje }}">
			{% for comentario in mensaje.IbcMensajeComentario %}
	   		<div class="comentario">
	   			<div class="foto"><a href="/sico/ibc_usuario/ver/{{ comentario.IbcUsuario.id_usuario }}"><img src="{{ comentario.IbcUsuario.foto }}" width="25px" height="25px"></a></div>
	   			<div class="texto"><a href="/sico/ibc_usuario/ver/{{ comentario.IbcUsuario.id_usuario }}">{{ comentario.IbcUsuario.nombre }}:</a> {{ comentario.comentario }}<div class='fecha'><?php $date = date_create($mensaje->fecha); ?><?php echo date_format($date, 'd/m/Y'); ?> <?php echo date_format($date, 'G:ia'); ?></div></div>
	   		</div>
	   		{% endfor %}
		</div>
		{% endif %}
		{{ form("ibc_mensaje/comentario/"~mensaje.id_mensaje, "method":"post", "parsley-validate" : "") }}
   		<div class="input-group">
	      {{ text_area("comentario", "rows" : "1", "class" : "form-control required", "placeholder" : "Escriba aquí su comentario...") }}
	      <span class="input-group-btn">
	        {{ submit_button("Guardar", "class" : "btn btn-primary") }}
	      </span>
	    </div>
   		</form>
	</div>
	{% endfor %}	
{% endif %}