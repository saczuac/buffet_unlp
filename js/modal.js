function mostrar(paramModal) {
  modal = document.getElementById(paramModal);
  modal.style.display = "block";
}

function cerrar() {
  modal.style.display = "none";
}

window.onclick = function(event) {
if (typeof modal !== 'undefined')
  {if (event.target == modal) {
      modal.style.display = "none";
    }}
}

function logued() {
  window.location.assign("loguedIndex");
}
