function mostrar(paramModal) {
  modal = document.getElementById(paramModal);
  modal.style.display = "block";
  document.getElementById("header").className = "borroso";
  document.getElementById("nav").className = "borroso";
 // document.getElementById("contenido").className = "borroso";
}

function cerrar() {
  modal.style.display = "none";
  document.getElementById("header").className = "";
  document.getElementById("nav").className = "";
  document.getElementById("contenido").className = "";
}

window.onclick = function(event) {
if (typeof modal !== 'undefined')
  {if (event.target == modal) {
      cerrar();
    }}
}

function logued() {
  window.location.assign("loguedIndex");
}
