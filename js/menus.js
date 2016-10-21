var index=0;
function agregar() {
    var fila = document.createElement("TR");
    index=index+1;
    fila.setAttribute("id",index);
    document.getElementById("ProductosMenu").appendChild(fila);
    var columnaNombre = document.createElement("td");
    var selectNombre = document.createElement("select");
    selectNombre.name = "idProducto";
    var option = document.createElement("option");
    option.text = "Elija un producto";
    selectNombre.add(option);
    for ( i=0; i < json.length; i++) {
            var option = document.createElement("option");
            option.text = json[i].nombre;
            option.value = json[i].id;
            selectNombre.add(option);
    };
    columnaNombre.appendChild(selectNombre);
    var columnaDelete = document.createElement("td");
    var aDelete =document.createElement("a");
    aDelete.setAttribute("href","#");
    var st="borrar("+String(index)+")"
    aDelete.setAttribute("onclick",st);
    aDelete.innerHTML = "X";
    columnaDelete.appendChild(aDelete);
    fila.appendChild(columnaNombre);
    fila.appendChild(columnaDelete);
}

function submitNew() {
  document.getElementById("formNew");
  var y=[];
  var ids = document.getElementsByName("idProducto");
  for (var i = 0; i < ids.length; i++) {
    if (ids[i].value!= ""){
      y[i*(3)]=ids[i].value;
    }
  }
  h = y.toString();
  var inputArray = document.createElement( "input" );
  inputArray.setAttribute( "name", "paramArray" );
  inputArray.setAttribute( "type", "hidden" );
  inputArray.setAttribute( "value", h );
  document.getElementById("formNew").appendChild( inputArray );
  document.getElementById("formNew").submit();
}

function borrar(id) {
    var list=document.getElementById("ProductosMenu");
    list.removeChild(list.childNodes[id]);
 }
