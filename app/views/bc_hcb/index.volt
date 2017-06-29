
{{ content() }}
<h1>Periodos - Cronograma Hogares Comunitarios</h1>
{% if (id_componente == 3) %}
{{ elements.getcronogramahcbMenu() }}
{% if (not(periodos is empty)) %}
{% for periodo in periodos %}
{{ link_to("bc_hcb/ver/"~periodo.id_hcbperiodo, periodo.getMes(), "class": "btn btn-default btn-lg btn-block") }}
{% endfor %}
{% endif %}
{% endif %}
{% if (id_componente == 2 or id_componente == 1 or id_componente == 4) %}
{{ elements.getcronogramahcbMenuIbc() }}
{% if (not(periodos is empty)) %}
    {% for periodo in periodos %}
    <div class="btn-group btn-group-justified" role="group" style="margin-bottom: 5px;">
      {{ link_to("bc_hcb/novedades/"~periodo.id_hcbperiodo, "Novedades "~ periodo.getMes(), "class": "btn btn-default btn-lg") }}
      {{ link_to("bc_hcb/ver/"~periodo.id_hcbperiodo, "Cronograma "~ periodo.getMes(), "class": "btn btn-default btn-lg") }}
    </div>
    {% endfor %}
{% endif %}
{% endif %}
