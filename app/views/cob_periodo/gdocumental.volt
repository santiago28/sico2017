
{{ content() }}
<h1>Actas Gestión Documental Periodo <?php echo $this->conversiones->fecha(5, $fecha_periodo); ?></h1>
{{ link_to("cob_periodo/recorrido/"~id_periodo~"/"~recorrido, '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }}
<table class="table table-bordered table-hover" id="recorrido">
    <thead>
        <tr>
            <th>No. Acta</th>
            <th>No. Contrato</th>
            <th>Prestador</th>
            <th>Mes</th>
            <th>Fecha de corte</th>
         </tr>
    </thead>
    <tbody>
    {% for acta in actas %}
        <tr>
            <td>{{ link_to(acta.getUrlDetail(), acta.getIdDetail()) }}</td>
            <td>{{ acta.id_contrato }}</td>
            <td>{{ acta.oferente_nombre }}</td>
            <td><?php echo $this->conversiones->fecha(5, $acta->CobPeriodo->fecha); ?></td>
            <td>{{ acta.CobPeriodo.fecha }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>