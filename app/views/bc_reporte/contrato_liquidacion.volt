
{{ content() }}
<h1>Liquidación<br><small>CONTRATO {{ contrato.id_contrato }} MODALIDAD {{ contrato.BcSedeContrato.modalidad_nombre }}</small></h1>
{{ link_to("bc_reporte/contratos_liquidacion") }}
<table class="table table-bordered table-hover">
	<thead>
    	 <tr>
            <th>NUMERO_ACTA1<input autocomplete='off' class='filter form-control input-sm' name='numero_acta1' data-col='numero_acta1'/></th>
            <th>NUMERO_ACTA2<input autocomplete='off' class='filter form-control input-sm' name='numero_acta2' data-col='numero_acta2'/></th>
            <th>NUMERO_ACTA3<input autocomplete='off' class='filter form-control input-sm' name='numero_acta3' data-col='numero_acta3'/></th>
            <th>FECHA_REPORTE<input autocomplete='off' class='filter form-control input-sm' name='fecha_reporte' data-col='fecha_reporte'/></th>
            <th>ID_SEDE<input autocomplete='off' class='filter form-control input-sm' name='id_sede' data-col='id_sede'/></th>
            <th>NOMBRE_SEDE<input autocomplete='off' class='filter form-control input-sm' name='nombre_sede' data-col='nombre_sede'/></th>
            <th>ID_PERSONA<input autocomplete='off' class='filter form-control input-sm' name='id_persona' data-col='id_persona'/></th>
            <th>NUIP<input autocomplete='off' class='filter form-control input-sm' name='nuip' data-col='nuip'/></th>
            <th>PRIMER_NOMBRE<input autocomplete='off' class='filter form-control input-sm' name='primer_nombre' data-col='primer_nombre'/></th>
            <th>SEGUNDO_NOMBRE<input autocomplete='off' class='filter form-control input-sm' name='segundo_nombre' data-col='segundo_nombre'/></th>
            <th>PRIMER_APELLIDO<input autocomplete='off' class='filter form-control input-sm' name='primer_apellido' data-col='primer_apellido'/></th>
            <th>SEGUNDO_APELLIDO<input autocomplete='off' class='filter form-control input-sm' name='segundo_apellido' data-col='segundo_apellido'/></th>
            <th>ASISTENCIA1<input autocomplete='off' class='filter form-control input-sm' name='asistencia1' data-col='asistencia1'/></th>
            <th>ASISTENCIA2<input autocomplete='off' class='filter form-control input-sm' name='asistencia2' data-col='asistencia2'/></th>
            <th>ASISTENCIA3<input autocomplete='off' class='filter form-control input-sm' name='asistencia3' data-col='asistencia3'/></th>
            <th>CERTIFICACIÓN_FINAL<input autocomplete='off' class='filter form-control input-sm' name='certificación_final' data-col='certificación_final'/></th>
            <th>OBSERVACIÓN_CERTIFICACION_FINAL<input autocomplete='off' class='filter form-control input-sm' name='observación_certificación_final' data-col='observación_certificación_final'/></th>
            <th>PERIODO<input autocomplete='off' class='filter form-control input-sm' name='periodo' data-col='periodo'/></th>
         </tr>
    </thead>
    <tbody>
    {% for beneficiario in beneficiarios %}
        <tr>
            <td>{{ beneficiario.acta1 }}</td>
            <td>{{ beneficiario.acta2 }}</td>
            <td>{{ beneficiario.acta3 }}</td>
            <td>{{ beneficiario.CobPeriodo.fecha }}</td>
            <td>{{ beneficiario.id_sede }}</td>
            <td>{{ beneficiario.BcSedeContrato.sede_nombre }}</td>
            <td>{{ beneficiario.id_persona }}</td>
            <td>{{ beneficiario.numDocumento }}</td>
            <td>{{ beneficiario.primerNombre }}</td>
            <td>{{ beneficiario.segundoNombre }}</td>
            <td>{{ beneficiario.primerApellido }}</td>
            <td>{{ beneficiario.segundoApellido }}</td>
            <td>{{ beneficiario.asistencia1 }}</td>
            <td>{{ beneficiario.asistencia2 }}</td>
            <td>{{ beneficiario.asistencia3 }}</td>
            <td>{{ beneficiario.getCertificacionLiquidacion() }}</td>
            <td></td>
            <td>{{ beneficiario.getPeriodo() }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>