{% if (not(cob_ajuste is empty)) %}
<table class="table table-bordered table-hover" id="reporte">
    <thead>
    	 <tr>
            <th>Periodo Verificado</th>
            <th>Entidad Prestadora</th>
            <th>Número de Contrato</th>
            <th>Modalidad de Atención</th>
            <th>Cupos de Ampliación Contratados</th>
            <th>Cupos de Sostenibilidad Contratados</th>
            <th>Total de cupos por contrato</th>
            <th>Total de cupos en el SIBC por contrato</th>
            <th>Código sede</th>
            <th>Nombre sede</th>
            <th>Total de cupos en el SIBC por sede</th>
            <th>Total de cupos Certificados por sede</th>
            <th>Total Ajustes</th>
            <th>Total Pagos</th>
            <th>Total Descuentos</th>
            <th>Total cupos a certificar</th>
         </tr>
    </thead>
    <tbody>
    {% for sede in cob_ajuste %}
    	<?php $cuposTotal = $sede->CobActaconteoPersonaFacturacion->CobPeriodoContratosedecupos->cuposTotal; ?>
    	<?php $cuposSIBCcontrato = $sede->CobActaconteoPersonaFacturacion->countBeneficiarioscontrato($sede->id_contrato, $sede->id_periodo); ?>
    	<?php $cuposSIBCsede = $sede->CobActaconteoPersonaFacturacion->countBeneficiariossede($sede->CobActaconteoPersonaFacturacion->id_sede, $sede->id_periodo); ?>
		<?php $cuposCertificadosFacturacion = $sede->CobActaconteoPersonaFacturacion->getCertificarSede($sede->id_sede_contrato, $sede->id_periodo); ?>
    	<?php $totalajuste = $sede->totalAjustesede($sede->id_ajuste_reportado, $sede->id_periodo, $sede->id_sede_contrato); ?>
    	<?php $totalajusteanterior = $sede->totalAjusteanteriorsede($sede->fecha_ajuste_reportado, $sede->id_periodo, $sede->id_sede_contrato); ?>
    	<?php $cuposCertificados = $cuposCertificadosFacturacion + ($totalajusteanterior['total']); ?>
    	<?php $edades = $sede->getEdadesSede($sede->id_ajuste_reportado, $sede->id_periodo, $sede->id_sede_contrato); ?>
        <tr>
            <td>{{ sede.CobPeriodo.getFechaDetail() }}</td>
            <td>{{ sede.CobActaconteoPersonaFacturacion.CobActaconteo.oferente_nombre }}</td>
            <td>{{ sede.id_contrato }}</td>
            <td>{{ sede.CobActaconteoPersonaFacturacion.CobActaconteo.modalidad_nombre }}</td>
            <td>{{ sede.CobActaconteoPersonaFacturacion.CobPeriodoContratosedecupos.cuposAmpliacion }}</td>
            <td>{{ sede.CobActaconteoPersonaFacturacion.CobPeriodoContratosedecupos.cuposSostenibilidad }}</td>
            <td>{{ cuposTotal }}</td>
            <td>{{ cuposSIBCcontrato }}</td>
            <td>{{ sede.CobActaconteoPersonaFacturacion.id_sede }}</td>
            <td>{{ sede.CobActaconteoPersonaFacturacion.CobActaconteo.sede_nombre }}</td>
            <td>{{ cuposSIBCsede }}</td>
            <td>{{ cuposCertificados }}</td>
            <td>{{ totalajuste['total'] }}</td>
            <td>{{ totalajuste['pagos'] }}</td>
            <td>{% if (totalajuste['descuentos'] > 0) %}-{% endif %}{{ totalajuste['descuentos'] }}</td>
	    	<td><?php echo $cuposCertificados + ($totalajuste['total']); ?></td>	    	
        </tr>
    {% endfor %}
    </tbody>
</table>
{% endif %}
