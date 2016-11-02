var index=0;
function agregarPedido() {
    var fila = document.createElement("TR");
    index=index+1;
    fila.setAttribute("id",index);
    document.getElementById("ProductosPedido").appendChild(fila);
    var columnaNombre = document.createElement("td");
    var selectNombre = document.createElement("select");
    selectNombre.name = "idProducto";
            var option = document.createElement("option");
            option.text = "Elija un producto";
            selectNombre.add(option);
    for ( i=0; i < json.length; i++) {
            var option = document.createElement("option");
            option.text = json[i][0].nombre;
            option.value = json[i][0].id;
            selectNombre.add(option);
    };
    columnaNombre.appendChild(selectNombre);
    var columnaCantidad = document.createElement("td");
    var columnaDelete = document.createElement("td");
    var inputCantidad = document.createElement("input");
    inputCantidad.setAttribute("type", "number");
    inputCantidad.setAttribute("name","cantidad");
    inputCantidad.setAttribute("step","1");
    inputCantidad.setAttribute("required", "true");
    var aDelete =document.createElement("a");
    aDelete.setAttribute("href","#");
    var st="borrarProducto("+String(index)+")"
    aDelete.setAttribute("onclick",st);
    aDelete.innerHTML = "X";
    columnaCantidad.appendChild(inputCantidad);
    columnaDelete.appendChild(aDelete);
    fila.appendChild(columnaNombre);
    fila.appendChild(columnaCantidad);
    fila.appendChild(columnaDelete);
}

function submitNewPedido() {
  document.getElementById("formNew");
  var y=[];
  var ids = document.getElementsByName("idProducto");
  var cants = document.getElementsByName("cantidad");
  for (var i = 0; i < ids.length; i++) {
    if ((ids[i].value!= "") && (cants[i].value!= "")){
      y.push(ids[i].value);
      y.push(cants[i].value);
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

  function borrarProducto(id) {
    var list=document.getElementById("ProductosPedido");
    list.removeChild(list.childNodes[id]);
 }
 function cerrarPedido(id) {
      modal = document.getElementById('cerrar');
      modal.style.display = "block";
      document.getElementById('idPedido').value=id;
 }
  function cerrarMP() {
      modal = document.getElementById('cerrar');
      modal.style.display = "none";
 }
