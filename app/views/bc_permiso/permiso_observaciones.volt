<ul style="margin-bottom: 5px;" class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#historico" id="historico-tab" role="tab" data-toggle="tab" aria-controls="historico" aria-expanded="true">Histórico de Eventos</a></li>
	{% if (not(permisos is empty)) %}<li role="presentation" class=""><a href="#otrospermisos" id="otrospermisos-tab" role="tab" data-toggle="tab" aria-controls="otrospermisos" aria-expanded="false">Otros Permisos</a></li>{% endif %}
	{% if (permiso.categoria > 1 and permiso.categoria < 5) %}<li role="presentation" class=""><a href="#listadoparticipantes" id="listadoparticipantes-tab" role="tab" data-toggle="tab" aria-controls="listadoparticipantes" aria-expanded="false">Listado de Participantes</a></li>{% endif %}
</ul>
<div class="tab-content">
	<div role="tabpanel" class="tab-pane fade active in" id="historico" aria-labelledby="historico-tab">
		<?php
		if(count($permiso->getBcPermisoObservacion()) > 0) {
		foreach($permiso->BcPermisoObservacion as $row) { ?>
			<div class="observacion">
		   		<div class="header">
				  <div class="foto">
				    <img src="{{ row.IbcUsuario.foto }}" width="40px" height="40px">
				  </div>
				  <div>
				  	<h3 style="margin: 0px;">{{ row.IbcUsuario.nombre }} <span class="label label-{{ row.getEstadoStyle() }}">{{ row.getEstado() }}</span></h3>
		   			<div class="info_anuncio"><?php $date = date_create($row->fechahora); ?><i class="fa fa-calendar"></i> <?php echo date_format($date, 'd/m/Y'); ?> <i class="fa fa-clock-o"></i> <?php echo date_format($date, 'G:ia'); ?> <span class="label label-success"></span></div>
				  </div>
				</div>
		   		<div class="contenido">{{ row.observacion }}</div>
		   	</div>
		<?php } } ?>
	</div>
	{% if (not(permisos is empty)) %}
	<div role="tabpanel" class="tab-pane fade" id="otrospermisos" aria-labelledby="otrospermisos-tab">
		<table class="table table-bordered table-hover" id="permisos_lista">
		    <thead>
		        <tr>
		            <th>ID Permiso</th>
								<th>Estado</th>
		            <th>Categoría</th>
		            <th>Prestador</th>
		            <th>Contrato-Modalidad</th>
		            <th>ID-Sede</th>
		            <th>Título</th>
		            <th>Fecha</th>
		            <th>Horas</th>
		         </tr>
		    </thead>
		    <tbody>
		    {% for otro_permiso in permisos %}
		        <tr>
		            <td><a rel="tooltip" title="Ver Detalles del Permiso" href="{{ url("bc_permiso/permiso/"~otro_permiso.id_permiso) }}">{{ otro_permiso.id_permiso }}</a></td>
								<td><a rel="tooltip" title="Ver Detalles del Permiso" href="{{ url("bc_permiso/permiso/"~otro_permiso.id_permiso) }}">{{ otro_permiso.getEstado() }}</a></td>
		            <td>{{ otro_permiso.getCategoria() }}</td>
		            <td>{{ otro_permiso.BcSedeContrato.oferente_nombre }}</td>
		            <td>{{ otro_permiso.BcSedeContrato.id_contrato }} - {{ otro_permiso.BcSedeContrato.modalidad_nombre }}</td>
		            <td>{{ otro_permiso.BcSedeContrato.id_sede }} - {{ otro_permiso.BcSedeContrato.sede_nombre }}</td>
		            <td>{{ otro_permiso.titulo }}</td>
		            <td><?php echo $this->conversiones->fecha(4, $otro_permiso->fecha); ?></td>
		            <td>{{ otro_permiso.horaInicio }} - {{ otro_permiso.horaFin }}</td>
		        </tr>
		    {% endfor %}
		    </tbody>
		</table>
	</div>
	{% endif %}
	<div role="tabpanel" class="tab-pane fade" id="listadoparticipantes" aria-labelledby="listadoparticipantes-tab">
		{% if (listado_beneficiarios is empty) %}
		<div class="alert alert-warning"><i class="glyphicon glyphicon-warning-sign"></i> Este permiso no cuenta con participantes, por favor ingrésalos a continuación:</div>
		{% endif %}
		{% if (agregar_participantes > 0) %}
		{{ form("bc_permiso/agregar_participantes/"~permiso.id_permiso, "id":"permiso_general_form", "method":"post", "parsley-validate" : "") }}
		<p>Puede copiar los beneficiarios directamente desde un archivo en Excel, seleccionando los datos de las columnas 'Nombre completo' y 'Nuip' en ese mismo orden como se muestra en <a id="paso1">esta imagen</a> y pegándolos en el cuadro siguiente como se puede <a id="paso2">ver aquí</a>.</p>
		{{ text_area("pegar_listado", "rows" : 2, "placeholder" : "Pegue aquí el listado de beneficiarios", "class" : "form-control", "style" : "margin-bottom: 5px;") }}
		{% endif %}
		<table class="table table-bordered table-hover" id="listado_participantes_lista">
		    <thead>
		        <tr>
								<th>#</th>
		            <th>Nombre Completo</th>
								<th>Número de Identificación</th>
								<th>X</th>
		         </tr>
		    </thead>
		    <tbody>
				{% if (listado_beneficiarios is not empty) %}
		    {% for beneficiario in listado_beneficiarios %}
		        <tr>
								<td><span class="number">{{ loop.index }}</span></td>
								<td>{{ beneficiario.nombreCompleto }}</td>
								<td><input type="hidden" class ='numDocumento' value='{{ beneficiario.numDocumento }}'>{{ beneficiario.numDocumento }}<div class="error_documento"></div></td>
								<td></td>
		        </tr>
		    {% endfor %}
				{% endif %}
				{% if (agregar_participantes > 0) %}
				<?php for ($i = 1; $i <= 500; $i++) { ?>
					<tr style="display: none;" class='limpiar'>
						<td><span class="number"><?php echo $i; ?></span></td>
						<td>{{ text_field("nombreCompleto[]", "disabled" : "disabled", "placeholder" : "Nombre Completo", "class" : "nombreCompleto form-control required") }}<div class="error_nombre"></div></td>
						<td>{{ text_field("numDocumento[]", "disabled" : "disabled", "placeholder" : "Número de documento", "class" : "numDocumento form-control required") }}<div class="error_documento"></div></td>
						<td style="text-align:center;"><a class='btn btn-default eliminar_valor'><i class='glyphicon glyphicon-remove'></i></a></td>
					</tr>
				<?php } ?>
				{% endif %}
		    </tbody>
		</table>
		{% if (agregar_participantes > 0) %}
		<div class="error_nopersonas"></div>
		<a class="btn btn-success pull-left" id="agregar_item_adicional"><i class="glyphicon glyphicon-plus"></i> Agregar Ítem</a>
		<a style ="margin-left: 3px" class="btn btn-success pull-left" id="limpiar_formulario"><i class="glyphicon glyphicon-refresh"></i> Limpiar Formulario</a>
		<a style ="margin-left: 3px" class="btn btn-primary submit_listado"><i class="glyphicon glyphicon-save"></i> Guardar Listado</a>
	</form>
	{% endif %}
	</div>
</div>
