{% if (not(contratos is empty)) %}
<table class="table table-bordered table-hover" id="reporte">
    <thead>
    	 <tr>
            <th>Periodo Verificado</th>
            <th>Entidad Prestadora</th>
            <th>Número de Contrato</th>
            <th>Modalidad de Atención</th>
            <th>Total de cupos en el SIBC</th>
            <th>Total de cupos a certificar Menores de 2 años</th>
            <th>Total de cupos a certificar Igual o mayor de 2 años y menor de 4 años</th>
            <th>Total de cupos a certificar Igual o mayor de 4 años y menor de 6 años</th>
            <th>Total de cupos a certificar Igual o mayor de 6 años</th>
            <th>Total de hogares comunitarios registrados en el SIBC x contrato</th>
            <th>Total hogares comunitarios x contrato</th>
            <th>Total beneficiarios certificados</th>
         </tr>
    </thead>
    <tbody>
    {% for contrato in contratos %}
    	<?php $edades = $contrato->getEdadesContrato($contrato->id_contrato, $contrato->id_periodo); ?>
    	<?php $certificados = $contrato->countBeneficiarioscertcontrato($contrato->id_contrato, $contrato->id_periodo); ?>
    	<?php $cuposSIBC = $contrato->countBeneficiarioscontrato($contrato->id_contrato, $contrato->id_periodo); ?>
    	<?php $gruposTotal = $contrato->countGruposcontrato($contrato->id_contrato, $contrato->id_periodo); ?>
    	<?php $hogaresContrato = $cuposTotal / 13; ?>
        <tr>
            <td>{{ contrato.CobPeriodo.getFechaDetail() }}</td>
            <td>{{ contrato.CobActaconteo.oferente_nombre }}</td>
            <td>{{ contrato.id_contrato }}</td>
            <td>{{ contrato.CobActaconteo.modalidad_nombre }}</td>
            <td>{{ cuposSIBC }}</td>
            <td>{{ edades['menor2'] }}</td>
            <td>{{ edades['mayorigual2menor4'] }}</td>
            <td>{{ edades['mayorigual4menor6'] }}</td>
            <td>{{ edades['mayorigual6'] }}</td>
            <td>{{ gruposTotal }}</td>
            <td>{{ hogaresContrato }}</td>
            <td>{{ certificados }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{% endif %}