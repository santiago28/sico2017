{{ content() }}
<h1>Cronograma {{ mes }} {{ sede.sede_nombre }}</h1>
{{ elements.getcronogramahcbMenu() }}
<ol class="breadcrumb">
  <li>{{ link_to("bc_hcb/", 'Periodos') }}</li>
  <li>{{ link_to("bc_hcb/ver/"~periodo.id_hcbperiodo, mes) }}</li>
  <li class="active">{{ sede.sede_nombre }}</li>
</ol>
<!-- Modal -->
<div class="modal fade" id="cancelar_fecha" tabindex="-1" role="dialog" aria-labelledby="cancelarFecha" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Cancelando visita</h4>
      </div>
      <div class="modal-body">
      {{ form("bc_hcb/cancelar_fecha/", "method":"post", "class":"", "id":"cancelar_fecha", "parsley-validate" : "") }}
          <p>Escribe el motivo por el cual vas a <span style='color: #d9534f; font-weight: bold'>cancelar</span> la visita  de <span style='font-weight: bold' class="nombre_cancelar"></span> para el día <span style='font-weight: bold' class="fecha_cancelar"></span>:</p>
          <p>{{ text_area("observacion", "maxlength" : "400", "parsley-maxlength" : "150", "rows" : "4", "class" : "form-control required") }}</p>
          <input type="hidden" name="id_hcbperiodo_empleado_fecha" class="id_elemento">
      </div>
      <div class="modal-footer">
        {{ submit_button("Guardar", "class" : "btn btn-primary") }}
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal -->
<div class="modal fade" id="crear_fecha" tabindex="-1" role="dialog" aria-labelledby="crearFecha" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Creando una nueva visita</h4>
      </div>
      <div class="modal-body">
      {{ form("bc_hcb/crear_fecha/", "method":"post", "class":"form-horizontal", "id":"crear_fecha", "parsley-validate" : "") }}
          <table class="table table-bordered table-hover empleados_lista">
              <thead>
                  <tr><th>#</th>
                      <th>Número de Documento</th>
                      <th>Nombre Completo</th>
                   </tr>
              </thead>
              <thead>
              	<tr><th style="margin: 0; padding: 0; border: 0" colspan="9"><a id='cleanfilters' class='btn btn-primary btn-sm btn-block'>Limpiar Filtros</a></th></tr>
              </thead>
              <tbody>
              {% for empleado in empleados %}
                  <tr>
                        <td><input type="radio" class="required" name="id_hcbempleado" required value="{{ empleado.id_hcbempleado }}"></td>
                        <td>{{ empleado.numDocumento }}</td>
                        <td>{{ empleado.getNombrecompleto() }}</td>
                  </tr>
              {% endfor %}
              </tbody>
          </table>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="jornada">Jornada:</label>
              <div class="col-sm-10">
                <div class="btn-group" data-toggle="buttons">
          			  <label class="btn btn-primary">
          			    <input type="radio" name="jornada" id="option1" autocomplete="off" value="1"> Mañana
          			  </label>
          			  <label class="btn btn-primary">
          			    <input type="radio" name="jornada" id="option2" autocomplete="off" value="2" class="required"> Tarde
          			  </label>
          			</div>
              </div>
          </div>
          <div class="form-group">
              <label class="col-sm-2 control-label" for="fecha">Fecha:</label>
              <div class="col-sm-10">
                <input class="fechaf_crear" type="hidden" value="" name="fecha">
                <input type="hidden" value="{{ periodo.id_hcbperiodo }}" name="id_hcbperiodo">
                <input type="hidden" value="{{ sede.id_sede_contrato }}" name="id_sede_contrato">
                <span class="fecha_crear"></span>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        {{ submit_button("Guardar", "class" : "btn btn-primary") }}
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{% if (activar_formulario == 1 ) %}
<h3>Seleccione los empleados para asignar fechas del mes</h3>
{{ form("bc_hcb/guardarcronograma/"~periodo.id_hcbperiodo~"/"~sede.id_sede_contrato, "method":"post", "parsley-validate" : "", "id" : "cronogramahcb_form", "class" : "form-container form-horizontal", "enctype" : "multipart/form-data" ) }}
<table class="table table-bordered table-hover empleados_lista">
    <thead>
        <tr><th>#</th>
            <th>Número de Documento</th>
            <th>Nombre Completo</th>
            <th>Jornada Mañana</th>
            <th>Jornada Tarde</th>
         </tr>
    </thead>
    <thead>
    	<tr><th style="margin: 0; padding: 0; border: 0" colspan="9"><a id='cleanfilters' class='btn btn-primary btn-sm btn-block'>Limpiar Filtros</a></th></tr>
    </thead>
    <tbody>
    {% for empleado in empleados %}
        <tr>
        	  <?php
            if(in_array($empleado->id_hcbempleado, $empleados_id)){ ?>
              <td><input type="checkbox" class="empleadocheck" checked="checked"></td>
              <td>{{ empleado.numDocumento }}</td>
              <td>{{ empleado.getNombrecompleto() }}</td>
              <td><input type="hidden" name="id_hcbempleado[]" value="{{ empleado.id_hcbempleado }}">{{ text_field("fechamaniana[]", "value" : empleado.getFechasmaniana(empleado.id_hcbempleado, periodo.id_hcbperiodo, sede.id_sede_contrato), "type" : "date", "class" : "form-control tipo-fecha required", "placeholder" : "dd/mm/aaaa", "data-date-format" : "dd/mm/yyyy") }}</td>
              <td>{{ text_field("fechatarde[]", "value" : empleado.getFechastarde(empleado.id_hcbempleado, periodo.id_hcbperiodo, sede.id_sede_contrato), "type" : "date", "class" : "form-control tipo-fecha", "placeholder" : "dd/mm/aaaa", "data-date-format" : "dd/mm/yyyy") }}</td>
            <?php } else { ?>
              <td><input type="checkbox" class="empleadocheck"></td>
              <td>{{ empleado.numDocumento }}</td>
              <td>{{ empleado.getNombrecompleto() }}</td>
              <td><input type="hidden" name="id_hcbempleado[]" value="{{ empleado.id_hcbempleado }}" class="tipo-fecha" disabled="disabled">{{ text_field("fechamaniana[]", "type" : "date", "class" : "form-control tipo-fecha required", "placeholder" : "dd/mm/aaaa", "data-date-format" : "dd/mm/yyyy", "disabled" : "disabled") }}</td>
              <td>{{ text_field("fechatarde[]", "type" : "date", "class" : "form-control tipo-fecha", "placeholder" : "dd/mm/aaaa", "data-date-format" : "dd/mm/yyyy", "disabled" : "disabled") }}</td>
            <?php } ?>

        </tr>
    {% endfor %}
    </tbody>
</table>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
          {{ submit_button("Guardar", "class" : "btn btn-default") }}
    </div>
</div>
<div id="festivos" style="display:none"><?php echo $this->elements->festivos(); ?></div>
<input type="hidden" name="fecha_inicio" id="fecha_inicio" value="{{ fecha_inicio }}">
<input type="hidden" name="fecha_fin" id="fecha_fin" value="{{ fecha_fin }}">
</form>
{% endif %}
<h3>Para cancelar una visita haga clic en la X al final del nombre del empleado y para crear una visita haga clic en el día al cual desea asignar un empleado</h3>
<br>
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
