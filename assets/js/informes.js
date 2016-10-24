$(document).ready(function(){
	/*
	 * Eventos para las tabs de Ingresos y Cuotas
	 *
	 * @author: Santiago Figueiras
	 *
	 */ 
	$("#trigger-ingresos").on('click', function(){
		$("#ingresos").addClass("in active");
		$("#cuotas").removeClass("in active");
	});

	$("#trigger-cuotas").on('click', function(){
		$("#cuotas").addClass("in active");
		$("#ingresos").removeClass("in active");
	});

	function renderTable(coleccion) {
		ingresos = JSON.parse(coleccion);

		var table = "<table id='datatable'>"
		table += "<thead>";
		table += "<tr>";
		table += "<th></th>";
		table += "<th>Ingresos</th>";
		table += "</tr>";
		table += "</thead>";
		table += "<tbody>";

		for (var i = ingresos.length - 1; i >= 0; i--) {
			console.log(ingresos[i]);

			table += "<tr>";
			table += "<th>" + ingresos[i].mes + "</th>";
			table += "<td>" + ingresos[i].cantidad + "</td>";
			table += "</tr>";
		};

		return table;
	} 

	function initializeChart() {
		$(function () {
		    $('#chart-container').highcharts({
		        data: {
		            table: 'datatable'
		        },
		        chart: {
		            type: 'column'
		        },
		        title: {
		            text: 'Ingresos en el año ' + anio
		        },
		        yAxis: {
		            allowDecimals: false,
		            title: {
		                text: 'Ingresantes'
		            }
		        },
		        tooltip: {
		            formatter: function () {
		                return '<b>' + this.series.name + '</b><br/>' +
		                    this.point.y + ' ' + this.point.name.toLowerCase();
		            }
		        }
		    });
		});
	}

	$("#submit-ingresos").on('submit', function(event){
		event.preventDefault();
		
		anio = $("#anio_ingreso").val();

		var url = '/api/ingresos/' + anio;
		$.get(url, function(data){
			
			var table = renderTable(data);

			$("#chart-container").html(table);
			//$("#content").append(table);

			$("#chart-container").css('display', 'block');

			initializeChart();
		});
	});

	function getEventObjectArray(pagas) {
		
		dates = new Array();
		for (var i = pagas.length - 1; i >= 0; i--) {
			fecha_pago = moment(new Date(pagas[i].fecha_pago.timestamp*1000)).format('YYYY-MM-DD');
			dates.push({ title: 'Pago', start: fecha_pago, allDay: true });
		};
		return dates;
	}


	/*
 	 * Configuración e inizialización del Calendario
 	 * Utilizando Full Calendar http://fullcalendar.io/
 	 *
 	 * @author: Santiago Figueiras
 	 *
 	 */
	function initializeCalendar(target, fechas) {
		$(target).fullCalendar({
			events: fechas,
			lang: 'es',
	        aspectRatio: 1.5
	    });
	}

	$("#submit-cuotas").on('submit', function(event){
		event.preventDefault();
		
		dni = $("#dni").val();
		anio = $("#anio").val();

		var url = '/api/cuotas/' + dni + '/' + anio;
		$.get(url, function(data){
			cuotas = JSON.parse(data);
			
			fechas_pagas = getEventObjectArray(cuotas.pagas);

			$cal = $("#calendar-container");
			$cal.css('display', 'block');

			initializeCalendar('#calendar', fechas_pagas);
		});
	});
});