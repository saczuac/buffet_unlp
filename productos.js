document.addEventListener("DOMContentLoaded", function(event) {
    var trs = document.querySelectorAll("tr");
    for(var i = 0; i < trs.length; i++){
    trs[i].id = i;
    trs[i].addEventListener("click", function(){
      if (this.className == "selected") {
         this.className = "";
         document.getElementById("editar").className = "action-button shadow animate disabled";
         document.getElementById("eliminar").className += "action-button shadow animate disabled";
      } else {
        selecteds = document.getElementsByClassName("selected");
        for(var j = 0; j < selecteds.length; j++){
            act = selecteds[j];
            document.getElementById(act.id).className = "";
        }
        this.className = "selected";
        document.getElementById("editar").className = "action-button shadow animate yellow active";
        document.getElementById("eliminar").className += "action-button shadow animate red active";
      }
    });
   };
});
