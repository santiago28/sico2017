
{{ content() }}
<h1>Reporte Salidas Aprobadas - {{ titulo }}</h1>
<a href='/sico/bc_permiso/reportes' class='btn btn-primary regresar'><i class='glyphicon glyphicon-chevron-left'></i> Reportes</a><br><br>
{% if (not(permisos is empty)) %}
<ul style="margin-bottom: 5px;" class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#general" id="general-tab" role="tab" data-toggle="tab" aria-controls="general" aria-expanded="true">General</a></li>
	<li role="presentation" class=""><a href="#listadoparticipantes" id="listadoparticipantes-tab" role="tab" data-toggle="tab" aria-controls="listadoparticipantes" aria-expanded="false">Participantes</a></li>
</ul>
<div class="tab-content">
	<div role="tabpanel" class="tab-pane fade active in" id="general" aria-labelledby="general-tab">
    <table class="table table-bordered table-hover" id="permisos_lista">
        <thead>
            <tr>
                <th>PRESTADOR</th>
                <th>SEDE</th>
                <th>FECHA ENCUENTRO</th>
                <th>HORA SALIDA</th>
                <th>HORA LLEGADA</th>
                <th>ACTIVIDAD</th>
                <th>LUGAR</th>
                <th>QUIEN REMITE LA INFORMACIÓN</th>
                <th>NÚMERO DE PARTICIPANTES</th>
             </tr>
        </thead>
        <tbody>
        {% for permiso in permisos %}
            <tr>
                <td>{{ permiso.BcSedeContrato.oferente_nombre }}</td>
                <td>{{ permiso.BcSedeContrato.sede_nombre }}</td>
                <td><?php echo $this->conversiones->fecha(4, $permiso->fecha); ?></td>
                <td>{{ permiso.horaInicio }}</td>
                <td>{{ permiso.horaFin }}</td>
                <td>{{ permiso.titulo|upper }}</td>
                <td>{{ permiso.BcPermisoGeneral.direccionEvento|upper}}</td>
                <td>ANA MARIA BERMUDEZ CORREA</td>
                <td>{{ permiso.countParticipantes() }}</td>
            </tr>
        {% endfor %}
        </tbody>
    </table>
  </div>
  <div role="tabpanel" class="tab-pane fade" id="listadoparticipantes" aria-labelledby="listadoparticipantes-tab">
    <table class="table table-bordered table-hover" id="permisos_lista">
        <thead>
            <tr>
                <th>PRESTADOR</th>
                <th>SEDE</th>
                <th>NUIP</th>
                <th>NOMBRE COMPLETO</th>
             </tr>
        </thead>
        <tbody>
        {% for permiso in permisos %}
          {% for participante in permiso.getBcPermisoParticipante() %}
            <tr>
                <td>{{ permiso.BcSedeContrato.oferente_nombre }}</td>
                <td>{{ permiso.BcSedeContrato.sede_nombre }}</td>
                <td>{{ participante.numDocumento }}</td>
                <td>{{ participante.nombreCompleto | upper }}</td>
            </tr>
            {% endfor %}
        {% endfor %}
        </tbody>
    </table>
  </div>
{% endif %}
