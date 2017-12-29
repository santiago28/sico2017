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
            <th>Total de cupos en el SIBC activos</th>
            <th>Total de cupos en el SIBC retirados en el periodo</th>
            <th>Total de cupos en el SIBC</th>
            <th>Total beneficiarios certificados</th>
            <th>Porcentaje de Cobertura certificado</th>
            <th>Porcentaje de Cobertura matriculado SIBC</th>
         </tr>
    </thead>
    <tbody>
    {% for contrato in contratos %}

    	<?php $certificados = $contrato->countBeneficiarioscertcontrato($contrato->id_contrato, $contrato->id_periodo); ?>
    	<?php $cuposTotal = $contrato->CobPeriodoContratosedecupos->cuposTotal; ?>
    	<?php $cuposSIBC = $contrato->countBeneficiarioscontrato($contrato->id_contrato, $contrato->id_periodo); ?>
        <tr>       
            
            <td>{{ contrato.CobPeriodo.getFechaDetail() }}</td>
            <td>{{ contrato.CobActaconteo.oferente_nombre }}</td>
            <td>{{ contrato.id_contrato }}</td>
            <td>{{ contrato.CobActaconteo.modalidad_nombre }}</td>
            <td>{% if (cuposTotal > 0) %}{{ contrato.CobPeriodoContratosedecupos.cuposAmpliacion }}{% endif %}</td>
            <td>{% if (cuposTotal > 0) %}{{ contrato.CobPeriodoContratosedecupos.cuposSostenibilidad }}{% endif %}</td>
            <td>{{ cuposTotal }}</td>
            <td>{{ contrato.CobActaconteo.getCuposActivosFamiliar() }}</td>
            <td>{{ contrato.CobActaconteo.getRetiradosFamiliar() }}</td>
            <td>{{ cuposSIBC }}</td>
            <td>{% if (certificados > cuposTotal) %}Se pasó{% else %}{{ certificados }}{% endif %}</td>
            <td>{% if (certificados > cuposTotal) %}Se pasó{% else %}<?php echo number_format($certificados / $cuposTotal * 100, 2, '.', ''); ?>%{% endif %}</td>
            <td>{% if (certificados > cuposTotal) %}Se pasó{% else %}<?php echo number_format($certificados / $cuposSIBC * 100, 2, '.', ''); ?>%{% endif %}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{% endif %}
