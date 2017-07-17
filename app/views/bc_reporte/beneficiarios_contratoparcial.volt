
{{ content() }}
<h1>Base de Datos Niño a Niño Consolidado Parcial 1er y 2do Recorridos {{ periodo.getFechaAnioDetail() }} <br><small>CONTRATO {{ contrato.id_contrato }} MODALIDAD {{ contrato.BcSedeContrato.modalidad_nombre }}</small></h1>
<div class='col-md-10'>
	{{ link_to("bc_reporte/oferente_periodos/"~contrato.id_contrato, '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
	<button class='btn btn-primary' id='ExportarExcel'>Exportar</button>
</div>
<table id='reporte' class="table table-bordered table-hover">
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
            <th>Acta R1<input autocomplete='off' class='filter form-control input-sm' name='acta r1' data-col='acta r1'/></th>
            <th>Asistencia R1<input autocomplete='off' class='filter form-control input-sm' name='asistencia r1' data-col='asistencia r1'/></th>
            <th>Observación R1<input autocomplete='off' class='filter form-control input-sm' name='observación r1' data-col='observación r1'/></th>
            <th>Certificación R1<input autocomplete='off' class='filter form-control input-sm' name='certificación r1' data-col='certificación r1'/></th>
            <th>Acta R2<input autocomplete='off' class='filter form-control input-sm' name='acta r2' data-col='acta r2'/></th>
            <th>Asistencia R2<input autocomplete='off' class='filter form-control input-sm' name='asistencia r2' data-col='asistencia r2'/></th>
            <th>Observación R2<input autocomplete='off' class='filter form-control input-sm' name='observación r2' data-col='observación r2'/></th>
            <th>Certificación R2<input autocomplete='off' class='filter form-control input-sm' name='certificación r2' data-col='certificación r2'/></th>
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
            <td>{{ beneficiario.acta1 }}</td>
            <td>{{ beneficiario.asistencia1 }}</td>
            <td>{{ beneficiario.getObservacion1() }}</td>
            <td>{{ beneficiario.getCertificacion1() }}</td>
            <td>{{ beneficiario.acta2 }}</td>
            <td>{{ beneficiario.asistencia2 }}</td>
            <td>{{ beneficiario.getObservacion2() }}</td>
            <td>{{ beneficiario.getCertificacion2() }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>


<script>
setTimeout(function(){
	$("#ExportarExcel").click(function(){
		var Export = [];
		{% for beneficiario in beneficiarios %}
			Export.push({
				"Nombre sede": "{{ beneficiario.CobActaconteo.sede_nombre }}",
				"Nombre Grupo": "{{ beneficiario.grupo }}",
				"ID Persona": "{{ beneficiario.id_persona }}",
				"Número documento": "{{ beneficiario.numDocumento }}",
				"Primer Nombre": "{{ beneficiario.primerNombre }}",
				"Segundo Nombre": "{{ beneficiario.segundoNombre }}",
				"Primer Apellido": "{{ beneficiario.primerApellido }}",
				"Segundo Apellido": "{{ beneficiario.segundoApellido }}",
				"Fecha Registro Matricula": "{{ beneficiario.fechaRegistro }}",
				"Fecha Registro Beneficiario": "{{ beneficiario.fechaInicioAtencion }}",
				"Fecha Retiro": "{{ beneficiario.fechaRetiro }}",
				"Acta R1": "{{ beneficiario.acta1 }}",
				"Asistencia R1": "{{ beneficiario.asistencia1 }}",
				"Observación R1": "{{ beneficiario.getObservacion1() }}",
				"Certificación R1": "{{ beneficiario.getCertificacion1() }}",
				"Acta R2": "{{ beneficiario.acta2 }}",
				"Asistencia R2": "{{ beneficiario.asistencia2 }}",
				"Observación R2": "{{ beneficiario.getObservacion2() }}",
				"Certificación R2": "{{ beneficiario.getCertificacion2() }}",
			})
		{% endfor %}
		alasql('SELECT * INTO XLSX("Reporte Niño a Niño R1 y R2.xlsx",{headers:true}) FROM ?', [Export]);
	});
}, 1000);
</script>
