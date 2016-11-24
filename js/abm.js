var idSelected =0;

function mostrarEdit() {
    document.location.href="/compras/edit/"+idSelected;
}

function mostrarDelete(id,form) {
  var st="/"+String(form)+"/"+String(id);
  document.getElementById("delete").setAttribute("action",st)
  mostrar('delete');
}

function mostrarDetalles() {
  document.location.href="/compras/show/"+idSelected;
}
function deleteTD(td) {
  var trs = document.querySelectorAll("tr");
  trs.removeChild(td);
}

$(document).ready(function () {
    $('#newRol').change(function() {
        if ($('#newRol option:selected').val() == 2) {
            document.getElementById("labelHabilitado").style.display = "inline-block";
            document.getElementById("labelUbicacion").style.display = "inline-block";
            document.getElementById("newUbicacion").style.display = "inline-block";
            document.getElementById("newHabilitado").style.display = "inline-block";
            $('#newHabilitado').prop('required',true);
            $('#newUbicacion').prop('required',true);
        } else {
            document.getElementById("labelHabilitado").style.display = "none";
            document.getElementById("labelUbicacion").style.display = "none";
            document.getElementById("newUbicacion").style.display = "none";
            document.getElementById("newHabilitado").style.display = "none";
            $('#newUbicacion').prop('required',false);
            $('#newHabilitado').prop('required',false);
        }
    });
});

document.addEventListener("DOMContentLoaded", function(event) {
    var trs = document.querySelectorAll("tr");
    for(var i = 1; i < trs.length; i++){
    trs[i].id = i;
    trs[i].addEventListener("click", function(){
      idSelected=this.getElementsByTagName("td")[0].innerHTML;
      if (this.className == "selected") {
         this.className = "";
         if (document.getElementById("editar")!= null) {
         document.getElementById("editar").className = "action-button shadow animate disabled";
         document.getElementById("editar").removeEventListener("click", mostrarEdit);}
         if (document.getElementById("eliminar")!= null) {
         document.getElementById("eliminar").className += "action-button shadow animate disabled";
         document.getElementById("eliminar").removeEventListener("click", mostrarDelete);}
         if (document.getElementById("detalles")!= null) {
        document.getElementById("detalles").className = "action-button shadow animate disabled";
        document.getElementById("detalles").addEventListener("click", mostrarDetalles);}
        if (document.getElementById("eliminarFila")!= null) {
        document.getElementById("eliminarFila").className += "action-button shadow animate disabled";
        document.getElementById("eliminarFila").removeEventListener("click",deleteTD);}
      } else {
        selecteds = document.getElementsByClassName("selected");
        for(var j = 0; j < selecteds.length; j++){
            act = selecteds[j];
            document.getElementById(act.id).className = "";
        }
        this.className = "selected";
        if (document.getElementById("editar")!= null) {
            document.getElementById("editar").className = "action-button shadow animate yellow active";
            document.getElementById("editar").addEventListener("click", mostrarEdit);
        }
        if (document.getElementById("eliminar")!= null) {
        document.getElementById("eliminar").className += "action-button shadow animate red active";
        }
        if (document.getElementById("detalles")!= null) {
        document.getElementById("detalles").className = "action-button shadow animate violet active";
        document.getElementById("detalles").addEventListener("click", mostrarDetalles);
        }
        if (document.getElementById("eliminarFila")!= null) {
        document.getElementById("eliminarFila").className += "action-button shadow animate red active";
        document.getElementById("eliminarFila").addEventListener("click", mostrarDelete);
        }
      }
    });
   };
});
