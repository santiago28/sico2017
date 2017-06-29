
{{ content() }}
<h1>Base de Datos Niño a Niño Consolidado Final {{ periodo.getFechaAnioDetail() }} <br><small>CONTRATO {{ contrato.id_contrato }} MODALIDAD {{ contrato.BcSedeContrato.modalidad_nombre }}</small></h1>
{{ link_to("bc_reporte/oferente_periodos/"~contrato.id_contrato, '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
<table class="table table-bordered table-hover">
	<thead>
    	 <tr>
            <th>Nombre Sede<input autocomplete='off' class='filter form-control input-sm' name='nombre sede' data-col='nombre sede'/></th>
            <th>Nombre Grupo<input autocomplete='off' class='filter form-control input-sm' name='nombre grupo' data-col='nombre grupo'/></th>
            <th>ID Persona<input autocomplete='off' class='filter form-control input-sm' name='id persona' data-col='id persona'/></th>
            <th>Número documento<input autocomplete='off' class='filter form-control input-sm' name='número documento' data-col='número documento'/></th>
            <th>Primer Nombre<input autocomplete='off' class='filter form-control input-sm' name='primer nombre' data-col='primer nombre'/></th>
            <th>Segundo Nombre<input autocomplete='off' class='filter form-control input-sm' name='segundo nombre' data-col='segundo nombre'/></th>
            <th>Primer Apellido<input autocomplete='off' class='filter form-control input-sm' name='primer apellido' data-col='primer apellido'/></th>
            <th>Segundo Apellido<input autocomplete='off' class='filter form-control input-sm' name='segundo apellido' data-col='segundo apellido'/></th>
            <th>Fecha Registro Matrícula<input autocomplete='off' class='filter form-control input-sm' name='fecha registro matrícula' data-col='fecha registro matrícula'/></th>
            <th>Fecha Registro Beneficiario<input autocomplete='off' class='filter form-control input-sm' name='fecha registro beneficiario' data-col='fecha registro beneficiario'/></th>
            <th>Fecha Retiro<input autocomplete='off' class='filter form-control input-sm' name='fecha retiro' data-col='fecha retiro'/></th>
            <th>Acta R3<input autocomplete='off' class='filter form-control input-sm' name='acta r3' data-col='acta r3'/></th>
            <th>Asistencia R3<input autocomplete='off' class='filter form-control input-sm' name='asistencia r3' data-col='asistencia r3'/></th>
            <th>Certificación R3<input autocomplete='off' class='filter form-control input-sm' name='certificación r3' data-col='certificación r3'/></th>
            <th>Observación R3<input autocomplete='off' class='filter form-control input-sm' name='observación r3' data-col='observación r3'/></th>
            <th>Certificación Recorridos<input autocomplete='off' class='filter form-control input-sm' name='certificación recorridos' data-col='certificación recorridos'/></th>
         </tr>
    </thead>
    <tbody>
    {% for beneficiario in beneficiarios %}
        <tr>
            <td>{{ beneficiario.CobActaconteo.sede_nombre }}</td>
            <td>{{ beneficiario.grupo }}</td>
            <td>{{ beneficiario.id_persona }}</td>
            <td>{{ beneficiario.numDocumento }}</td>
            <td>{{ beneficiario.primerNombre }}</td>
            <td>{{ beneficiario.segundoNombre }}</td>
            <td>{{ beneficiario.primerApellido }}</td>
            <td>{{ beneficiario.segundoApellido }}</td>
            <td>{{ beneficiario.fechaRegistro }}</td>
            <td>{{ beneficiario.fechaInicioAtencion }}</td>
            <td>{{ beneficiario.fechaRetiro }}</td>
            <td>{{ beneficiario.acta3 }}</td>
            <td>{{ beneficiario.asistencia3 }}</td>
            <td>{{ beneficiario.getCertificacion3() }}</td>
            <td>{{ beneficiario.getObservacion3() }}</td>
            <td>{{ beneficiario.getCertificacionRecorridos() }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>