
{{ content() }}
<h1>Reportes de Salidas Aprobadas</h1>
<a href='/sico/bc_permiso/mes' class='btn btn-primary regresar'><i class='glyphicon glyphicon-chevron-left'></i> Lista de Permisos</a><br>
<br>
{% if (not(permisos is empty)) %}
<table class="table table-bordered table-hover" id="permisos_lista">
    <thead>
        <tr>
            <th>FECHA</th>
         </tr>
    </thead>
    <tbody>
    {% for permiso in permisos %}
        <tr>
            <td><a rel="tooltip" title="Ver Reporte" href="{{ url("bc_permiso/reporte/"~permiso.fechaAprobacion) }}"><?php echo $this->conversiones->fecha(4, $permiso->fechaAprobacion); ?></a></td>
        </tr>
    {% endfor %}
    </tbody>
</table>
{% endif %}
