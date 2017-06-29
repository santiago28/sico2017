{% if (not(sedes is empty)) %}
<table class="table table-bordered table-hover" id="reporte">
    <thead>
    	 <tr>
            <th>Periodo Verificado</th>
            <th>Entidad Prestadora</th>
            <th>Número de Contrato</th>
            <th>Cupos de Ampliación Contratados</th>
            <th>Cupos de Sostenibilidad Contratados</th>
            <th>Total de cupos por contrato</th>
            <th>Total de cupos en el SIBC por contrato</th>
            <th>Modalidad de Atención</th>
            <th>Código sede</th>
            <th>Nombre sede</th>
            <th>Total de cupos en el SIBC por sede</th>
            <th>Total de cupos por sede</th>
            <th>Total beneficiarios que asistieron (1)</th>
            <th>Total beneficiarios retirados antes del día de corte de periodo (4)</th>
            <th>Total beneficiarios retirados después del día de corte de periodo (5)</th>
            <th>Total beneficiarios ausentes sin excusa al momento de la visita (6)</th>
            <th>Total beneficiarios con excusa médica mayor o igual a 15 días (7)</th>
            <th>Total beneficiarios con excusa médica menor a 15 días (8)</th>
            <th>Total beneficiarios certificados por ajuste posterior al recorrido (10)</th>
            <th>Total beneficiarios descontados por ajuste posterior al recorrido (11)</th>
            <th>Total de cupos a certificar</th>            
            <th>Total de cupos a certificar Menores de 2 años</th>
            <th>Total de cupos a certificar Igual o mayor de 2 años y menor de 4 años</th>
            <th>Total de cupos a certificar Igual o mayor de 4 años y menor de 6 años</th>
            <th>Total de cupos a certificar Igual o mayor de 6 años</th>
            <th>Cantidad de madres comunitarias x sede</th>
         </tr>
    </thead>
    <tbody>
    {% for sede in sedes %}
    	<?php $edades = $sede->getEdadesSede($sede->id_sede_contrato, $sede->id_periodo); ?>
    	<?php $asistencia = $sede->getAsistenciaSede($sede->id_sede_contrato, $sede->id_periodo); ?>
    	<?php $cuposTotal = $sede->CobPeriodoContratosedecupos->cuposTotal; ?>
    	<?php $cuposSIBCcontrato = $sede->countBeneficiarioscontrato($sede->id_contrato, $sede->id_periodo); ?>
    	<?php $cuposSIBCsede = $sede->countBeneficiariossede($sede->id_sede, $sede->id_periodo); ?>
    	<?php $gruposTotal = $sede->countGrupossede($sede->id_sede_contrato, $sede->id_periodo); ?>
        <tr>
            <td>{{ sede.CobPeriodo.getFechaDetail() }}</td>
            <td>{{ sede.CobActaconteo.oferente_nombre }}</td>
            <td>{{ sede.id_contrato }}</td>
            <td>{{ sede.CobPeriodoContratosedecupos.cuposAmpliacion }}</td>
            <td>{{ sede.CobPeriodoContratosedecupos.cuposSostenibilidad }}</td>
            <td>{{ cuposTotal }}</td>
            <td>{{ cuposSIBCcontrato }}</td>
            <td>{{ sede.CobActaconteo.modalidad_nombre }}</td>
            <td>{{ sede.id_sede }}</td>
            <td>{{ sede.CobActaconteo.sede_nombre }}</td>
            <td>{{ cuposSIBCsede }}</td>
            <td>{{ sede.CobPeriodoContratosedecupos.cuposSede }}</td>
            <td>{{ asistencia['asiste1'] }}</td>
            <td>{{ asistencia['asiste4'] }}</td>
            <td>{{ asistencia['asiste5'] }}</td>
            <td>{{ asistencia['asiste6'] }}</td>
            <td>{{ asistencia['asiste7'] }}</td>
            <td>{{ asistencia['asiste8'] }}</td>
            <td>{{ asistencia['asiste10'] }}</td>
            <td>{% if (asistencia['asiste11'] > 0) %}-{% endif %}- {{ asistencia['asiste11'] }}</td>
            <td><?php echo $sede->getCertificarSede($sede->id_sede_contrato, $sede->id_periodo); ?></td>
            <td>{{ edades['menor2'] }}</td>
            <td>{{ edades['mayorigual2menor4'] }}</td>
            <td>{{ edades['mayorigual4menor6'] }}</td>
            <td>{{ edades['mayorigual6'] }}</td>
            <td>{{ gruposTotal }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{% endif %}