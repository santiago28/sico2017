
{{ content() }}
<h1>{{ mes }} - Cronograma Hogares Comunitarios</h1>
{% if (id_componente == 3) %}
{{ elements.getcronogramahcbMenu() }}
{% endif %}
{% if (id_componente == 2 or id_componente == 1 or id_componente == 4) %}
{{ elements.getcronogramahcbMenuIbc() }}
{% endif %}
<ol class="breadcrumb">
  <li>{{ link_to("bc_hcb/", 'Periodos') }}</li>
  <li class="active">Cronograma {{ mes }}</li>
</ol>
{% if (not(sedes is empty)) %}
<table class="table table-bordered table-hover filtro_hcb" id="recorrido">
    <thead>
        <tr><th>#</th>
            <th>No. Contrato</th>
            {% if (nivel <= 2 ) %}<th>Prestador</th>{% endif %}
            <th>Sede</th>
            <th>Madre Comunitaria</th>
         </tr>
    </thead>
    <thead>
      <tr><th style="margin: 0; padding: 0; border: 0" colspan="9"><a id='cleanfilters' class='btn btn-primary btn-sm btn-block'>Limpiar Filtros</a></th></tr>
    </thead>
    <tbody>
    {% for sede in sedes %}
        <tr>
        	<td>{{ loop.index }}</td>
            <td>{{ link_to("bc_hcb/cronograma/"~periodo.id_hcbperiodo~"/"~sede.id_sede_contrato, sede.id_contrato) }}</td>
            {% if (nivel <= 2 ) %}<td>{{ link_to("bc_hcb/cronograma/"~periodo.id_hcbperiodo~"/"~sede.id_sede_contrato, sede.oferente_nombre) }}{{ sede.oferente_nombre }}</td>{% endif %}
            <td>{{ link_to("bc_hcb/cronograma/"~periodo.id_hcbperiodo~"/"~sede.id_sede_contrato, sede.sede_nombre) }}</td>
            <td>{% if (sede.getCobActaconteo()) %}{{ link_to("bc_hcb/cronograma/"~periodo.id_hcbperiodo~"/"~sede.id_sede_contrato, sede.CobActaconteo.CobActaconteoMcb.getNombrecompleto()) }}{% endif %}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{% endif %}
