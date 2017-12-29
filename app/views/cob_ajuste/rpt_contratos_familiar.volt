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
            <th>Total de cupos certificados</th>
            <th>Total Ajustes</th>
            <th>Total Pagos</th>
            <th>Total Descuentos</th>
            <th>Total cupos a certificar</th>
         </tr>
    </thead>
    <tbody>
    {% for contrato in cob_ajuste %}
    	<?php $cuposTotal = $contrato->CobActaconteoPersonaFacturacion->CobPeriodoContratosedecupos->cuposTotal; ?>
    	<?php $cuposSIBCcontrato = $contrato->CobActaconteoPersonaFacturacion->countBeneficiarioscontrato($contrato->id_contrato, $contrato->id_periodo); ?>
    	<?php $cuposCertificadosFacturacion = $contrato->CobActaconteoPersonaFacturacion->getCertificarContrato($contrato->id_contrato, $contrato->id_periodo); ?>
    	<?php $totalajuste = $contrato->totalAjustecontrato($contrato->id_ajuste_reportado, $contrato->id_periodo, $contrato->id_contrato); ?>
    	<?php $totalajusteanterior = $contrato->totalAjusteanteriorcontrato($contrato->fecha_ajuste_reportado, $contrato->id_periodo, $contrato->id_contrato); ?>
    	<?php $cuposCertificados = $cuposCertificadosFacturacion + ($totalajusteanterior['total']); ?>
    	<?php $edades = $contrato->getEdadesContrato($contrato->id_ajuste_reportado, $contrato->id_periodo, $contrato->id_contrato); ?>
        <tr>
            <td>{{ contrato.CobPeriodo.getFechaDetail() }}</td>
            <td>{{ contrato.CobActaconteoPersonaFacturacion.CobActaconteo.oferente_nombre }}</td>
            <td>{{ contrato.id_contrato }}</td>
            <td>{{ contrato.CobActaconteoPersonaFacturacion.CobActaconteo.modalidad_nombre }}</td>
            <td>{{ contrato.CobActaconteoPersonaFacturacion.CobPeriodoContratosedecupos.cuposAmpliacion }}</td>
            <td>{{ contrato.CobActaconteoPersonaFacturacion.CobPeriodoContratosedecupos.cuposSostenibilidad }}</td>
            <td>{{ cuposTotal }}</td>
            <td>{{ cuposSIBCcontrato }}</td>
            <td>{{ cuposCertificados }}<br><?php echo $totalajusteanterior['total']; ?></td>
            <td>{{ totalajuste['total'] }}</td>
            <td>{{ totalajuste['pagos'] }}</td>
            <td>{% if (totalajuste['descuentos'] > 0) %}-{% endif %}{{ totalajuste['descuentos'] }}</td>
	    	<td><?php echo $cuposCertificados + ($totalajuste['total']); ?></td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{% endif %}
