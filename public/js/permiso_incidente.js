var festivos = $("#festivos").html().split(',');
$('#incidente_form .tipo-fecha').datepicker({
    format: "dd/mm/yyyy",
    datesDisabled: festivos,
    weekStart: 0,
    startDate: $('#fecha_inicio').val(),
    endDate: $('#fecha_fin').val(),
    language: "es",
    daysOfWeekDisabled: "0,6"
});

// initialize datepair
$('tr').datepair();