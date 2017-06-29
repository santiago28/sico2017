{{ content() }}
<h1>Reportes de Ajustes</h1>
{{ link_to("cob_ajuste/", '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
{% if (not(fechas is empty)) %}
<table class="table table-bordered table-hover">
    <thead>
            <th>Fecha de Reporte</th>
            <th>Periodo</th>
            <th>Reporte Contratos</th>
            <th>Reporte Sedes</th>
         </tr>
    </thead>
    <tbody>
    {% for fecha in fechas %}
        <tr>
            <td>{{ fecha.CobAjusteReportado.fecha }}</td>
            <td>{{ fecha.CobPeriodo.getFechaDetail() }} - {{ fecha.CobPeriodo.getTipoperiodoDetail() }}</td>
            <td>{{ link_to("cob_ajuste/reportecontratos/"~fecha.id_ajuste_reportado~"/"~fecha.id_periodo~"/"~fecha.CobPeriodo.tipo, "<i class='glyphicon glyphicon-book'></i>" ) }}</td>
            <td>{{ link_to("cob_ajuste/reportesedes/"~fecha.id_ajuste_reportado~"/"~fecha.id_periodo~"/"~fecha.CobPeriodo.tipo, "<i class='glyphicon glyphicon-file'></i>" ) }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{% endif %}