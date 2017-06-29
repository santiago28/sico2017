
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("cob_periodo/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("cob_periodo/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>Id Of Periodo</th>
            <th>Fecha</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for cob_periodo in page.items %}
        <tr>
            <td>{{ cob_periodo.id_periodo }}</td>
            <td>{{ cob_periodo.fecha }}</td>
            <td>{{ link_to("cob_periodo/edit/"~cob_periodo.id_periodo, "Edit") }}</td>
            <td>{{ link_to("cob_periodo/delete/"~cob_periodo.id_periodo, "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("cob_periodo/search", "First") }}</td>
                        <td>{{ link_to("cob_periodo/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("cob_periodo/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("cob_periodo/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
