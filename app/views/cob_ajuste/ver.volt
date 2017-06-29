
{{ content() }}
<h1>Periodo</h1>
{{ link_to("cob_periodo/index", '<i class="glyphicon glyphicon-chevron-left"></i> Regresar', "class": "btn btn-primary menu-tab") }} 
{% if (not(recorridos is empty)) %}
{% for recorrido in recorridos %}
{{ link_to("cob_periodo/recorrido/"~id_periodo~"/"~recorrido.recorrido, "Recorrido "~recorrido.recorrido, "class": "btn btn-default btn-lg btn-block") }}
{% endfor %}
{% endif %}
{% if crear_recorrido == 1 %}
{{ link_to("cob_periodo/nuevorecorrido1/"~id_periodo, "Generar Recorrido 1", "class": "btn btn-primary btn-lg btn-block") }}
{% else %}
{{ link_to("cob_periodo/nuevorecorrido/"~id_periodo,  "Generar Recorrido "~crear_recorrido, "class": "btn btn-primary btn-lg btn-block") }}
{% endif %}