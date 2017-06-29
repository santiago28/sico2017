{{ content() }}
<h1>Cronograma {{ mes }} {{ sede.sede_nombre }}</h1>
{{ elements.getcronogramahcbMenuIbc() }}
<ol class="breadcrumb">
  <li>{{ link_to("bc_hcb/", 'Periodos') }}</li>
  <li>{{ link_to("bc_hcb/ver/"~periodo.id_hcbperiodo, mes) }}</li>
  <li class="active">{{ sede.sede_nombre }}</li>
</ol>
<p>
M: Jornada Mañana<br>
T: Jornada Tarde<br>
Eventos: <span class="label label-primary">Visita</span> <span class="label label-danger">Visita Cancelada</span> <span class="label label-success">Visita Nueva</span>
</p>
<table style="table-layout: fixed" class="table table-bordered table-hover">
  <thead>
      <tr>
        <th colspan="5" style="text-align: center;">{{ mes }}</th>
      </tr>
      <tr>
        <th>Lunes</th>
        <th>Martes</th>
        <th>Miércoles</th>
        <th>Jueves</th>
        <th>Viernes</th>
       </tr>
  </thead>
  <tbody>
    {{ cronograma }}
  </tbody>
</table>
<div class='clear'></div>
