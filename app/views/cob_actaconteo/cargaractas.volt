{{ content() }}
{{ elements.getActamenu(acta) }}
<h1>Cargas Actas - Plantillas</h1>
{{ link_to("cob_actaconteo/nuevo/"~id_actaconteo, '<i class="glyphicon glyphicon-plus"></i> Nueva Carga Acta', "class": "btn btn-primary menu-tab-first") }}
{% if (not(bc_carga_acta is empty)) %}
<table class="table table-bordered table-hover">
    <thead>
    	<tr>
            <th style="text-align:center" colspan="6">CARGAS ACTAS - PLANTILLAS</th>
         </tr>
        <tr>
            <th>Archivo Acta</th>
            <th>Acta</th>
            <th>Mes</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Interventor</th>
         </tr>
    </thead>
    <tbody>
    {% for bc_carga_acta in bc_carga_acta %}
        <tr>
            <td>{{ link_to("files/cob_bd/"~bc_carga_acta.nombreArchivo, bc_carga_acta.nombreArchivo, "target" : "_blank") }}</td>
            <td>{{ link_to(acta.getUrlDetail(), acta.getIdDetail()) }}</td><!-- <td>{{ bc_carga_acta.CobActaconteo.id_actaconteo }}</td> -->
            <td><?php echo $this->conversiones->mes(1, $bc_carga_acta->mes); ?></td>
            <!-- <td>{{ bc_carga_acta.fecha }}</td>-->
            <td><?php $arrfechahora = explode(" ", $bc_carga_acta->fecha); echo $this->conversiones->fecha(4, $arrfechahora[0]); ?></td>
            <td><?php $arrfechahora1 = explode(" ", $bc_carga_acta->fecha); echo $this->conversiones->hora2(1, $arrfechahora1[1]); ?></td>
            <td>{{ bc_carga_acta.IbcUsuario.usuario }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{% endif %}
<div class='clear'></div>
