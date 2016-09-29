function mostrarEdit() {
  mostrar('edit');
}
function mostrarDelete() {
  mostrar('delete');
}

document.addEventListener("DOMContentLoaded", function(event) {
    var trs = document.querySelectorAll("tr");
    for(var i = 1; i < trs.length; i++){
    trs[i].id = i;
    trs[i].addEventListener("click", function(){
      if (this.className == "selected") {
         this.className = "";
         document.getElementById("editar").className = "action-button shadow animate disabled";
         document.getElementById("editar").removeEventListener("click", mostrarEdit);
         document.getElementById("eliminar").className += "action-button shadow animate disabled";
         document.getElementById("eliminar").removeEventListener("click", mostrarDelete);
      } else {
        selecteds = document.getElementsByClassName("selected");
        for(var j = 0; j < selecteds.length; j++){
            act = selecteds[j];
            document.getElementById(act.id).className = "";
        }
        this.className = "selected";
        document.getElementById("editar").className = "action-button shadow animate yellow active";
        document.getElementById("editar").addEventListener("click", mostrarEdit);
        document.getElementById("eliminar").className += "action-button shadow animate red active";
        document.getElementById("eliminar").addEventListener("click", mostrarDelete);
      }
    });
   };
});

$(document).ready(function () {
    $('#newRol').change(function() {
        if ($('#newRol option:selected').text() == 2) {
            document.getElementById("labelRol").style.display = "inline-block";
            document.getElementById("newRol").style.display = "inline-block";
            $('#newRol').prop('required',true);
        }
    });
});
