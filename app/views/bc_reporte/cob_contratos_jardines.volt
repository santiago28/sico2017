{% if (not(contratos is empty)) %}
<table class="table table-bordered table-hover" id="reporte">
    <thead>
    	 <tr>
            <th>Periodo Verificado</th>
            <th>Entidad Prestadora</th>
            <th>Número de Contrato</th>
            <th>Modalidad de Atención</th>
            <th>Cupos de Ampliación Contratados</th>
            <th>Cupos de Sostenibilidad Contratados</th>
            <th>Total de cupos Contratados</th>
            <th>Total de cupos en el SIBC</th>
            <th>Total de cupos a certificar Menores de 2 años</th>
            <th>Total de cupos a certificar Igual o mayor de 2 años y menor de 4 años</th>
            <th>Total de cupos a certificar Igual o mayor de 4 años y menor de 6 años</th>
            <th>Total de cupos a certificar Igual o mayor de 6 años</th>
            <th>Total CUPOS 1/4 UPA ATENCION JARDIN  CERTIFICADOS de niñas y niños contados en el período x sede</th>
            <th>Total CUPOS JARDIN INFANTIL CERTIFICADOS de niñas y niños contados en el período x sede</th>
            <th>Total beneficiarios certificados</th>
            <th>Porcentaje de Cobertura certificado</th>
            <th>Porcentaje de Cobertura matriculado SIBC</th>
         </tr>
    </thead>
    <tbody>
    {% for contrato in contratos %}
    	<?php $edades = $contrato->getEdadesContrato($contrato->id_contrato, $contrato->id_periodo); ?>
    	<?php $certificados = $contrato->countBeneficiarioscertcontrato($contrato->id_contrato, $contrato->id_periodo); ?>
    	<?php $cuposTotal = $contrato->CobPeriodoContratosedecupos->cuposTotal; ?>
    	<?php $cuposSIBC = $contrato->countBeneficiarioscontrato($contrato->id_contrato, $contrato->id_periodo); ?>
    	<?php $gruposTotal = $contrato->countGruposcontrato($contrato->id_contrato, $contrato->id_periodo); ?>
        <tr>
            <td>{{ contrato.CobPeriodo.getFechaDetail() }}</td>
            <td>{{ contrato.CobActaconteo.oferente_nombre }}</td>
            <td>{{ contrato.id_contrato }}</td>
            <td>{{ contrato.CobActaconteo.modalidad_nombre }}</td>
            <td>{{ contrato.CobPeriodoContratosedecupos.cuposAmpliacion }}</td>
            <td>{{ contrato.CobPeriodoContratosedecupos.cuposSostenibilidad }}</td>
            <td>{{ cuposTotal }}</td>
            <td>{{ cuposSIBC }}</td>
            <td>{{ edades['menor2'] }}</td>
            <td>{{ edades['mayorigual2menor4'] }}</td>
            <td>{{ edades['mayorigual4menor6'] }}</td>
            <td>{{ edades['mayorigual6'] }}</td>
            <td><?php echo $contrato->getCertificar4UPAContrato($contrato->id_contrato, $contrato->id_periodo); ?></td>
            <td><?php echo $contrato->getCertificarno4UPAContrato($contrato->id_contrato, $contrato->id_periodo); ?></td>
            <td>{% if (certificados > cuposTotal) %}Se pasó{% else %}{{ certificados }}{% endif %}</td>
            <td>{% if (certificados > cuposTotal) %}Se pasó{% else %}<?php echo number_format($certificados / $cuposTotal * 100, 2, '.', ''); ?>%{% endif %}</td>
            <td>{% if (certificados > cuposTotal) %}Se pasó{% else %}<?php echo number_format($certificados / $cuposSIBC * 100, 2, '.', ''); ?>%{% endif %}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{% endif %}