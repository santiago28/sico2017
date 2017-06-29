
{{ content() }}
<h1>Nuevo Permiso</h1>
<a href='/sico/bc_permiso/mes' class='btn btn-primary regresar'><i class='glyphicon glyphicon-chevron-left'></i> Lista de Permisos</a><br>
<h3>1. Haz clic en el tipo de permiso que vas a crear</h3>
{{ link_to("bc_permiso/nuevo/salida_pedagogica/", "Salida Pedagógica", "class": "btn btn-primary btn-lg btn-block") }}
{{ link_to("bc_permiso/nuevo/movilizacion_social/", "Movilización Social", "class": "btn btn-primary btn-lg btn-block") }}
{{ link_to("bc_permiso/nuevo/salida_ludoteka/", "Salida a Ludoteka", "class": "btn btn-primary btn-lg btn-block") }}
{{ link_to("bc_permiso/nuevo/jornada_planeacion/", "Jornada de Planeación", "class": "btn btn-primary btn-lg btn-block") }}
{{ link_to("bc_permiso/nuevo/incidente/", "Incidente", "class": "btn btn-primary btn-lg btn-block") }}
{{ link_to("bc_permiso/nuevo/jornada_formacion/", "Jornada de Formación", "class": "btn btn-primary btn-lg btn-block") }}