
{{ content() }}
<?php $this->partial("bc_permiso/permiso_encabezado"); ?>
<table class='table table-bordered table-hover'>
	<thead>
		<tr>
			<th colspan="5" style="text-align:center;">INFORMACIÓN PERMISO<br>ESTADO ACTUAL: <span class="label label-{{ permiso.getEstadoStyle() }}">{{ permiso.getEstado() }}</span></th>
		</tr>
		<tr>
			<th>ID</th>
			<th>Fecha Solicitud</th>
			<th>Categoría</th>
			<th>Motivo Permiso</th>
			<th>Fecha</th>
			<th>Observaciones</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{ permiso.id_permiso }}</td>
			<td><?php $arrfechahora = explode(" ", $permiso->fechahora); echo $this->conversiones->fecha(4, $arrfechahora[0]); ?></td>
			<td>{{ permiso.getCategoria() }}</td>
			<td>{{ permiso.titulo }}</td>
			<td><?php echo $this->conversiones->fecha(4, $permiso->fecha); ?></td>
			<td>{{ permiso.observaciones }}</td>
		</tr>
	</tbody>
</table>
<?php $this->partial("bc_permiso/permiso_observaciones"); ?>