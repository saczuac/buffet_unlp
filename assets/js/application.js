$(document).ready(function(){
	$("input[type=datepicker]").datepicker(
		{
			dateFormat: "dd-mm-yy",
			changeYear: true,
			yearRange: "1950:"
		}
	);

	$("#delete").on("click", function(event){
		if(!(confirm("¿Esta seguro que quiere eliminar?"))) {
			event.preventDefault();
		}
	});

	$(".flash").on('click', function(){
		$(this).fadeOut("slow");
	});

	$(".flash").delay(5000).fadeOut("slow");

	/*
	 * Navigation collapsable bar
	 * Author: Santiago Figueiras
	 */

	$("#collapse").mouseover(function(){
		$('.collapsible-nav').fadeIn(250);
	});

	$(".collapsible-nav").mouseleave(function(){
		$(this).fadeOut(250);
	});

	/*
	 * Sugeridor de direccion con la API de OpenStreetMap 
	 * http://nominatim.openstreetmap.org/
	 *
	 * El evento se dispara cuando alguno de los dos campos está
	 * siendo completado, y el otro ya tiene algún valor.
	 *
	 * @author = Santiago José Figueiras
	 */

	function renderSuggestion(direccion) {
		return "<li class='suggestion'>"
					.concat(direccion.display_name)
					.concat("<span class='location-params longitud'>")
					.concat(direccion.lon)
					.concat("</span>")
					.concat("<span class='location-params latitud'>")
					.concat(direccion.lat)
					.concat("</span>")
					.concat("</li>");
	}

	/*
	 * Renderizar sugerencias según calle y número
	 * mediante la API de OpenStreetMap - http://nominatim.openstreetmap.org
	 *
	 * @author: Santiago Figueiras
	 */

	function renderSuggestionsFor(calle, numero) {

		partido = encodeURIComponent("La Plata");
		localidad = encodeURIComponent("La Plata");
		provincia = encodeURIComponent("Buenos Aires");
		url = "http://nominatim.openstreetmap.org/search?format=json&q=";
		
		// Cuando se levanta una tecla oprimida	
		params = [numero, calle, localidad, provincia];
		full_url = url.concat(params.join());	

		// Mando get request con la direccion actual 
		$.get(full_url, function(data){
			$("#suggestions").html("");
			$("#suggestions").css('display', 'block');
			$.each(data, function(index, direccion){
				suggestion = renderSuggestion(direccion);
				$("#suggestions").append(suggestion);
			});
		});
	}

	/*
	 * Triggers para renderizar las sugerencias
	 *
	 * @author: Santiago Figueiras
	 */

	$("#calle").keyup(function(){
		calle = $(this).val();
		numero = $("#numero").val();
		if(numero != null && numero != "") {
				renderSuggestionsFor(calle, numero);
		}
	});

	$("#numero").keyup(function(){
		calle = $("#calle").val();
		numero = $(this).val();
		if(calle != null && calle != "") {
				renderSuggestionsFor(calle, numero);
		}
	});

	$("#numero").trigger('keyup');

	/*
	 * DEBUG PARA EL FORMULARIO
	 *
	 *
	 *	$("#alumnos_new").submit(function(event){
	 *		event.preventDefault();
	 *		console.log($(this).serialize());
	 *	});
	*/

	function showMapModal() {
		modal = $("#map-modal");
		modal.css('opacity', 'inherit');
		modal.css('z-index', 'inherit');
		modal.css('transform', 'inherit');
	}

	function hideModal() {
		modal.css('opacity', '0');
		modal.css('z-index', '-100');
		modal.css('transform', 'scale(0.5)');
	}

	$("#close-modal").on('click', function(){
		hideModal();
	});

	/*
	 * Obtener los recorridos del formulario
	 *
	 * @author: Santiago José Figueiras
	 *
	 */

	map = null;
	
	function initializePathMap(target) {
		if(map == null) {
			map = L.map(target);
		}
	}

	function setCenter(coords, zoom) {
		map.setView(coords, zoom);
	}	

	function cleanLayers() {
		map.eachLayer(function (layer) {
		    map.removeLayer(layer);
		});
	}

	function addRoute(latitudDesde, longitudDesde, latitudHasta, longitudHasta) {
		L.Routing.control({
       	  show: false,	
		  waypoints: [
		    L.latLng(latitudDesde, longitudDesde),
		    L.latLng(latitudHasta, longitudHasta)
		  ]
		}).addTo(map);
	}

	$("#recorridos_form").on("submit", function(){

		event.preventDefault();
		input = $(this).serialize();
		$.post("alumnos/recorridos", input)
			.done(function(data){
				alumnos = $.parseJSON(data);
				showMapModal();

				navigator.geolocation.getCurrentPosition(function(position) {
					longitud = position.coords.longitude;
					latitud = position.coords.latitude;
					origen = [latitud, longitud].join();

					initializePathMap('pathsMap');
					setCenter([latitud, longitud], 13);
					cleanLayers();

					var marker = L.marker([latitud, longitud]).addTo(map);
					marker.bindPopup("<b>¡Aca estás vos!</b>").openPopup();

					L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
					    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
					    maxZoom: 18,
					    id: 'santif.cigobeb62001vusm173pfe8vo',
					    accessToken: 'pk.eyJ1Ijoic2FudGlmIiwiYSI6ImNpZ29iZWNqdjAwMjd1Y2tvcmp0NnprbWYifQ.XZbFbob5PAjhp3UC6vilbQ'
					}).addTo(map);

					var lonAnexa = -57.93995;
					var latAnexa = -34.90586;
					var anexa = L.marker([latAnexa, lonAnexa]).addTo(map);
					anexa.bindPopup("<b>Escuela Anexa</b>").openPopup();					

					for(i=0; i < alumnos.length; i++) {
						longitudActual = alumnos[i].longitud;
						latitudActual  = alumnos[i].latitud;
						destino = [latitudActual, longitudActual].join();
				       	
				       	addRoute(latitud, longitud, latitudActual, longitudActual);
						addRoute(latAnexa, lonAnexa, latitudActual, longitudActual);
						
						L.marker([latitudActual, longitudActual]).addTo(map);
					}
					console.log(map);
				});
		});
	});
});

/*
 * MAPA PARA ALTA Y EDICION DE ALUMNO
 *
 * @author: Santiago Figueiras
 */

var markerMap = null;
var currentMarker = null;

/*
 * Inicializa el mapa - en caso de que no haya sido 
 * inicializado previamente
 *
 * @author: Santiago Figueiras
 */

function initializeMarkerMap(id){
	markerMap = L.map(id);
	
	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
	    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
	    maxZoom: 18,
	    id: 'santif.cigobeb62001vusm173pfe8vo',
	    accessToken: 'pk.eyJ1Ijoic2FudGlmIiwiYSI6ImNpZ29iZWNqdjAwMjd1Y2tvcmp0NnprbWYifQ.XZbFbob5PAjhp3UC6vilbQ'
	}).addTo(markerMap);
}

/*
 * Marca una posicion [latitud, longitud] en el mapa.
 *
 * @author: Santiago Figueiras
 */

function mark(latitud, longitud) {
	if(markerMap == null) 
		initializeMarkerMap("markerMap");

	if(currentMarker != null)
		markerMap.removeLayer(currentMarker);
	markerMap.setView([latitud, longitud], 13);
	currentMarker = L.marker([latitud, longitud]).addTo(markerMap);
}

/*
 * Event Handler para desplegar el mapa cuando se
 * hace click en una sugerencia
 *
 * @author: Santiago Figueiras
 */

$(document).on('click', '.suggestion', function(event){

	$('.suggestion-selected').removeClass('suggestion-selected');
	$(this).toggleClass('suggestion-selected');

	longitud = $(this).find(".longitud").text();
	latitud = $(this).find(".latitud").text();

	$("#longitud").val(longitud);
	$("#latitud").val(latitud);

	mark(latitud, longitud);
});