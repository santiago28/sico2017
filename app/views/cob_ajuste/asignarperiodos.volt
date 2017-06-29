
{{ content() }}
<h1>Asignar Ajustes a fechas de Reporte - Periodos</h1> 
{{ link_to("cob_ajuste/", '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
{% if (not(ajustes is empty)) %}
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Periodo</th>
            <th>Fecha de Corte</th>
         </tr>
    </thead>
    <tbody>
    {% for cob_ajuste in ajustes %}
        <tr>
        <?php $periodo = $this->conversiones->fecha(5, $cob_ajuste->CobPeriodo->fecha); ?>
        <td>{{ link_to("cob_ajuste/asignarperiodo/"~cob_ajuste.CobPeriodo.fecha, periodo) }}</td>
        <td>{{ link_to("cob_ajuste/asignarperiodo/"~cob_ajuste.CobPeriodo.fecha, cob_ajuste.CobPeriodo.fecha) }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{% endif %}