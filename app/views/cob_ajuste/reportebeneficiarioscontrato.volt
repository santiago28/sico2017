
{{ content() }}
<h1>Base de Datos Niño a Niño Ajustes del periodo {{ periodo.getFechaAnioDetail() }} fecha  {{ fecha }}<br><small>CONTRATO {{ contrato.id_contrato }} MODALIDAD {{ contrato.modalidad_nombre }}</small></h1>
{{ link_to("bc_reporte/beneficiarios_contratoajustes/"~periodo.id_periodo~"/"~contrato.id_contrato, '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
<table class="table table-bordered table-hover">
	<thead>
    	 <tr>
            <th>Nombre Sede<input autocomplete='off' class='filter form-control input-sm' name='nombre sede' data-col='nombre sede'/></th>
            <th>Nombre Grupo<input autocomplete='off' class='filter form-control input-sm' name='nombre grupo' data-col='nombre grupo'/></th>
            <th>ID Persona<input autocomplete='off' class='filter form-control input-sm' name='id persona' data-col='id persona'/></th>
            <th>Número documento<input autocomplete='off' class='filter form-control input-sm' name='numero documento' data-col='numero documento'/></th>
            <th>Primer Nombre<input autocomplete='off' class='filter form-control input-sm' name='primer nombre' data-col='primer nombre'/></th>
            <th>Segundo Nombre<input autocomplete='off' class='filter form-control input-sm' name='segundo nombre' data-col='segundo nombre'/></th>
            <th>Primer Apellido<input autocomplete='off' class='filter form-control input-sm' name='primer apellido' data-col='primer apellido'/></th>
            <th>Segundo Apellido<input autocomplete='off' class='filter form-control input-sm' name='segundo apellido' data-col='segundo apellido'/></th>
            <th>Fecha Registro Matrícula<input autocomplete='off' class='filter form-control input-sm' name='fecha registro matricula' data-col='fecha registro matricula'/></th>
            <th>Fecha Registro Beneficiario<input autocomplete='off' class='filter form-control input-sm' name='fecha registro beneficiario' data-col='fecha registro beneficiario'/></th>
            <th>Fecha Retiro<input autocomplete='off' class='filter form-control input-sm' name='fecha retiro' data-col='fecha retiro'/></th>
            <th>Certificación Ajuste<input autocomplete='off' class='filter form-control input-sm' name='certificacion ajuste' data-col='certificacion ajuste'/></th>
         </tr>
    </thead>
    <tbody>
    {% for beneficiario in cob_ajuste %}
        <tr>
            <td>{{ beneficiario.CobActaconteoPersonaFacturacion.CobActaconteo.sede_nombre }}</td>
            <td>{{ beneficiario.CobActaconteoPersonaFacturacion.grupo }}</td>
            <td>{{ beneficiario.CobActaconteoPersonaFacturacion.id_persona }}</td>
            <td>{{ beneficiario.CobActaconteoPersonaFacturacion.numDocumento }}</td>
            <td>{{ beneficiario.CobActaconteoPersonaFacturacion.primerNombre }}</td>
            <td>{{ beneficiario.CobActaconteoPersonaFacturacion.segundoNombre }}</td>
            <td>{{ beneficiario.CobActaconteoPersonaFacturacion.primerApellido }}</td>
            <td>{{ beneficiario.CobActaconteoPersonaFacturacion.segundoApellido }}</td>
            <td>{{ beneficiario.CobActaconteoPersonaFacturacion.fechaRegistro }}</td>
            <td>{{ beneficiario.CobActaconteoPersonaFacturacion.fechaInicioAtencion }}</td>
            <td>{{ beneficiario.CobActaconteoPersonaFacturacion.fechaRetiro }}</td>
            <td>{{ beneficiario.getCertificarDetail() }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>