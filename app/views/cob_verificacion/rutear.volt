
{{ content() }}
<h1>Rutear Verificación</h1>
<!-- Modal -->
	<div class="modal fade" id="rutear_recorrido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Rutear</h4>
	      </div>
	      <div class="modal-body">
	      	<div class="input-group">
			  <span class="input-group-addon">Buscar</span>
			  <input class='form-control search_input' type='text' placeholder='Escribe el término a buscar'>
			</div>
	      	<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Rutear</th>
						<th>Periodo</th>
						<th>Tipo</th>
						<th>Recorrido</th>
					</tr>
				</thead>
				<tbody class="search_list">
					{% for periodo in periodos %}
					<tr>
						<td><a class="btn btn-link periodo_select" rel="tooltip" title="Rutear"><i class="glyphicon glyphicon-plus"></i></a></td>
						<td><span class="id_periodo" id="{{ periodo.id_periodo }}"></span><span class="recorrido" id="{{ periodo.recorrido }}"></span>{{ periodo.CobPeriodo.getFechaDetail() }}</td>
						<td>Recorrido {{ periodo.CobPeriodo.getTipoperiodoDetail() }}</td>
						<td>Recorrido {{ periodo.recorrido }}</td>
					</tr>
					{% endfor %}
					{% for verificacion in verificaciones %}
					<tr>
						<td><a class="btn btn-link periodo_select" rel="tooltip" title="Rutear"><i class="glyphicon glyphicon-plus"></i></a></td>
						<td><span class="id_periodo" id="{{ periodo.id_periodo }}"></span><span class="recorrido" id="{{ periodo.recorrido }}"></span>{{ periodo.CobPeriodo.getFechaDetail() }}</td>
						<td>Verificacion {{ verificacion.CobVerificacion.getTipo() }}</td>
						<td></td>
					</tr>
					{% endfor %}
				</tbody>
			</table>
			{{ form("cob_verificacion/ruteodesdeotroguardar/"~id_verificacion, "method":"post", "name":"ruteodesdeotro") }}
			<input type="hidden" name="id_periodo_actualizar" class="ruteo_id_periodo">
			<input type="hidden" name="recorrido_actualizar" class="ruteo_recorrido">
			</form>
			{{ form("cob_verificacion/ruteodesdeotroverificacionguardar/"~id_verificacion, "method":"post", "name":"ruteodesdeotroverificacion") }}
			<input type="hidden" name="id_verificacion_actualizar" class="ruteo_id_verificacion">
			</form>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
{{ link_to("cob_verificacion/ver/"~id_verificacion, '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
<a href="#rutear_recorrido" data-toggle="modal" class="btn btn-primary menu-tab"><i class="glyphicon glyphicon-road"></i> Rutear desde otro periodo</a>
{{ form("cob_verificacion/ruteoguardar/"~id_verificacion, "method":"post", "name":"ruteo") }}
<table class="table table-bordered table-hover" id="ruteo">
    <thead>
        <tr><th>#</th>
            <th><i class="glyphicon glyphicon-remove uncheck" style="text-align: center; cursor:pointer; width: 100%"></i></th>
            <th>Interventor</th>
            <th>No. Acta</th>
            <th>Modalidad</th>
            <th>Prestador</th>
            <th>Sede</th>
            <th>Barrio</th>
            <th>Dirección</th>
            <th>Beneficiarios</th>

         </tr>
    </thead>
    <tbody>
    {% for acta in actas %}
   		{% if ((acta.id_usuario is empty)) %}
        <tr>
        	<td>{{ loop.index }}</td>
        	<td><input type="checkbox" class="acta_check" id="{{ acta.getId() }}" value="{{ acta.getId() }}"><input type="hidden" name="id_acta[]" class="id_acta" value="{{ acta.getId() }}" disabled="disabled"><input type="hidden" name="contador_asignado[]" class="contador_asignado" disabled="disabled"></td>
        	<td class='interventor'><span class="no_asignado">No asignado</span></td>
        	{% else %}
        <tr class="success">
        	<td>{{ loop.index }}</td>
        	<td><input type="checkbox" class="acta_check" id="{{ acta.getId() }}" value="{{ acta.getId() }}"><input type="hidden" name="id_acta[]" class="id_acta" value="{{ acta.getId() }}" disabled="disabled"><input type="hidden" name="contador_asignado[]" class="contador_asignado" disabled="disabled"></td>
        	<td class='interventor'><span class="asignado">{{ acta.IbcUsuario.usuario }}</span></td>
        	{% endif %}
            <td>{{ link_to(acta.getUrlDetail(), '<span class="nombre_lista" id="'~acta.getId()~'">'~acta.getIdDetail()~'</span>') }}</td>
            <td>{{ acta.modalidad_nombre }}</td>
            <td>{{ acta.oferente_nombre }}</td>
            <td>{{ acta.id_sede }} - {{ acta.sede_nombre }}</td>
            <td>{{ acta.sede_barrio }}</td>
            <td>{{ acta.sede_direccion }}</td>
            <td>{{ acta.countBeneficiarios() }}</td>

        </tr>
    {% endfor %}
    </tbody>
</table>
 <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-bottom" role="navigation">
      <div class="container">
      	<div class="row">
	      <div class="col-lg-6" style="padding-top: 7px;">
	      	<div class="input-group">
			  <span class="input-group-addon"><span id="num_check">0</span> actas seleccionadas</span>
			  <select name="contador" id="contador" class="form-control">
	        	<option value="" selected="selected">Seleccionar...</option>
				{% for interventor in interventores %}
					<option value='{{ interventor.id_usuario }}'>{{ interventor.usuario }}</option>
				{% endfor %}
				<option value="NULL">Inhabilitar</option>
            </select>
            <span class="input-group-btn">
            	<span class="btn btn-default disabled" id="asignar_contador">Asignar</span>
           	</span>

			</div>
	      </div>
	      <div class="col-lg-3" style="padding-top: 7px;">
		      <div class="btn-group" style="margin-left: 20px;">
	            	<span class="btn btn-default quitar_select" disabled="disabled">Limpiar</span>
		            <button type="submit" class="btn btn-primary guardar_ruteo" disabled="disabled">Guardar</button>
	           	</div>
	      </div>
	      <div class="col-lg-3" style="padding-top: 12px;">
	      	<div class="input-group navbar-right">
			  <span class="actas_ruteadas">0</span> actas asignadas | <span class="actas_por_rutear">0</span> actas sin asignar
			</div>
	      </div>
	      </form>
	    </div>
      </div>
    </div>
