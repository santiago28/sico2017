
{{ content() }}
<?php $this->partial("bc_permiso/permiso_encabezado"); ?>
<table class='table table-bordered table-hover'>
	<thead>
		<tr>
			<th colspan="14" style="text-align:center;">INFORMACIÓN PERMISO<br>ESTADO ACTUAL: <span class="label label-{{ permiso.getEstadoStyle() }}">{{ permiso.getEstado() }}</span></th>
		</tr>
		<tr>
			<th>ID</th>
			<th>Fecha Solicitud</th>
			<th>Categoría</th>
			<th>Nombre del Evento</th>
			<th>Fecha</th>
			<th>Hora Inicio</th>
			<th>Hora Fin</th>
			<th>Objetivo Salida</th>
			<th>Actores que Apoyan el Evento</th>
			<th>Dirección y lugar del Evento</th>
			<th>Persona Contacto del Escenario</th>
			<th>Teléfonos de la Persona de Contacto</th>
			<th>Email de la Persona de Contacto</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{ permiso.id_permiso }}</td>
			<td><?php $arrfechahora = explode(" ", $permiso->fechahora); echo $this->conversiones->fecha(4, $arrfechahora[0]); ?></td>
			<td>{{ permiso.getCategoria() }}</td>
			<td>{{ permiso.titulo }}</td>
			<td><?php echo $this->conversiones->fecha(4, $permiso->fecha); ?></td>
			<td><?php echo $this->conversiones->hora2(1, $permiso->horaInicio); ?></td>
			<td><?php echo $this->conversiones->hora2(1, $permiso->horaFin); ?></td>
			<td>{{ permiso.observaciones }}</td>
			<td>{{ permiso.BcPermisoGeneral.actores }}</td>
			<td>{{ permiso.BcPermisoGeneral.direccionEvento }}</td>
			<td>{{ permiso.BcPermisoGeneral.personaContactoEvento }}</td>
			<td>{{ permiso.BcPermisoGeneral.telefonoContactoEvento }}</td>
			<td>{{ permiso.BcPermisoGeneral.emailContactoEvento }}</td>
		</tr>
		<?php if($permiso->BcPermisoGeneral->requiereTransporte == 1){ ?>
		<tr>
			<th colspan="14" style="text-align:center;">Transporte</th>
		</tr>
		<tr>
			<th colspan="3">RUNT del Conductor</th>
			<th colspan="3">RUNT del Vehículo</th>
			<th colspan="3">Póliza de Responsabilidad Civil</th>
			<th colspan="3">Tarjeta de Operación del Vehículo</th>
		</tr>
		<tr>
			<td colspan="3"><a target="_blank" href="/sico/files/permisos/{{ permiso.BcPermisoGeneralTransporte.runtConductor }}">Clic para ver Archivo</a></td>
			<td colspan="3"><a target="_blank" href="/sico/files/permisos/{{ permiso.BcPermisoGeneralTransporte.runtVehiculo }}">Clic para ver Archivo</a></td>
			<td colspan="3"><a target="_blank" href="/sico/files/permisos/{{ permiso.BcPermisoGeneralTransporte.polizaResponsabilidadCivil }}">Clic para ver Archivo</a></td>
			<td colspan="3"><a target="_blank" href="/sico/files/permisos/{{ permiso.BcPermisoGeneralTransporte.tarjetaOperacionVehiculo }}">Clic para ver Archivo</a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php $this->partial("bc_permiso/permiso_observaciones"); ?>
