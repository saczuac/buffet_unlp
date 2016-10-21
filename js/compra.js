  var index=0;
  function agregar() {
      var fila = document.createElement("TR");
      index=index+1;
      fila.setAttribute("id",index);
      document.getElementById("ProductosCompra").appendChild(fila);
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
      var columnaCantidad = document.createElement("td");
      var columnaPrecioUnitario = document.createElement("td");
      var columnaDelete = document.createElement("td");
      var inputCantidad = document.createElement("input");
      inputCantidad.setAttribute("type", "number");
      inputCantidad.setAttribute("name","cantidad");
      inputCantidad.setAttribute("step","1");
      inputCantidad.setAttribute("required", "true");
      var inputPrecioUnitario = document.createElement("input");
      inputPrecioUnitario.setAttribute("type", "number");
      inputPrecioUnitario.setAttribute("name", "precioUnitario");
      inputPrecioUnitario.setAttribute("step", "0.05");
      inputPrecioUnitario.setAttribute("required", "true");
      var aDelete =document.createElement("a");
      aDelete.setAttribute("href","#");
      var st="borrar("+String(index)+")"
      aDelete.setAttribute("onclick",st);
      aDelete.innerHTML = "X";
      columnaCantidad.appendChild(inputCantidad);
      columnaPrecioUnitario.appendChild(inputPrecioUnitario);
      columnaDelete.appendChild(aDelete);
      fila.appendChild(columnaNombre);
      fila.appendChild(columnaCantidad);
      fila.appendChild(columnaPrecioUnitario);
      fila.appendChild(columnaDelete);
  }
  function submitNew() {
    document.getElementById("formNew");
    var y=[];
    var ids = document.getElementsByName("idProducto");
    var cants = document.getElementsByName("cantidad");
    var pus = document.getElementsByName("precioUnitario");
    for (var i = 0; i < ids.length; i++) {
      if ((ids[i].value!= "") && (cants[i].value!= "") && (pus[i].value!= "")){
      y[i*(3)]=ids[i].value;
      y[(i*(3))+1]=cants[i].value;
      y[(i*(3))+2]=pus[i].value;}
    }
    h=y.toString();
    var inputArray = document.createElement( "input" );
    inputArray.setAttribute( "name", "paramArray" );
    inputArray.setAttribute( "type", "hidden" );
    inputArray.setAttribute( "value", h );
    document.getElementById("formNew").appendChild( inputArray );
    document.getElementById("formNew").submit();
  }
      function submitEdit(id) {
    document.getElementById("formEdit");
    var y=[];
    var ids = document.getElementsByName("idProducto");
    var vacio=0;
    var cants = document.getElementsByName("cantidad");
    var pus = document.getElementsByName("precioUnitario");
    for (var i = 0; i < ids.length; i++) {
      if ((ids[i].value!= "") && (cants[i].value!= "") && (pus[i].value!= "")){
        y[i*(3)]=ids[i].value;
        y[(i*(3))+1]=cants[i].value;
        y[(i*(3))+2]=pus[i].value;}
      else{
      }
    }
    h=y.toString();
    var inputArray = document.createElement( "input" );
    inputArray.setAttribute( "name", "paramArray" );
    inputArray.setAttribute( "type", "hidden" );
    inputArray.setAttribute( "value", h );
    inputArray.setAttribute( "required", "true" );
    document.getElementById("formEdit").appendChild(inputArray);
    var inputID = document.createElement( "input" );
    inputID.setAttribute( "name", "paramID" );
    inputID.setAttribute( "type", "hidden" );
    inputID.setAttribute( "required", "true" );
    inputID.setAttribute( "value", id );
    document.getElementById("formEdit").appendChild(inputID);
    document.getElementById("formEdit").submit();
  }
    function borrar(id) {
      var list=document.getElementById("ProductosCompra");
      list.removeChild(list.childNodes[id]);
   }
     function deleteCompra() {
    confirmar=confirm("Realmente desea eliminar esta compra ?");
    if (confirmar){
    var href="/compras/delete/"+String(idSelected);
    window.location.href=href;}
  }
