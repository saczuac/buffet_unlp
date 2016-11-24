<%@ taglib uri="M4Tags" prefix="m4" %><%@ page import="java.io.*, java.util.*, java.net.*" %>
<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "DTD/xhtml1-transitional.dtd">
<html>
<head><%@ page  import="com.meta4.session.*, com.meta4.m4operations.*,com.meta4.utilities.*" %>
<title>Titulo</title>
<link href="/css/estilo_mss.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="/libreria/funciones_sse_val1.js"></script>
<script type="text/javascript" src="/libreria/funciones_sse.js"></script>
<%@ include file="../../mss_generico/espanol/menu_mss.jsp" %>
<%
// Requerido para VALIDACION
Generatablaparametros zobjtabla = new Generatablaparametros(request);
String estado =  zobjtabla.m4paramvalor("estado");
String zfiltro = zobjtabla.m4paramvalor("zfiltro");
String znivel = zobjtabla.m4paramvalor("znivel");
String zinicios = zobjtabla.m4paramvalor("zinicios");	
if ((estado==null)||(estado.equals(""))){estado="0";}
if ((zfiltro==null)|| (""==zfiltro)){zfiltro = "Todos";} 
if (znivel==null){znivel = "1";}
if ((zinicios==null)||(zinicios.equals(""))){zinicios = "1";}
%>
<script type="text/javascript">
function filtrar(){
var valor =m4select("filtro","prueba","value");
var nivel =m4select("nivel","prueba","value");
m4valor("oculto","zfiltro",valor,"set");
m4valor("oculto","znivel",nivel,"set");
m4submit("oculto");
}
// Funcion de env�o. Solo se modifica el valor del TAG
function m4enviar(){
	var cadena="";
	var URL = "{TAG=SSE_...";
	if (typeof(document.forms['a0']) != "undefined"){
		var numregistros = parseInt(document.forms['a0'].elements[1].name);
		cadena = cadena + URL;
		for (var i = 0; i < numregistros; i++){
			var formulario = "b" + i;
			if (document.forms[formulario].elements[0].checked == true){
				var formulario1 = "a" + i;
				cadena = cadena + "{" + document.forms[formulario1].elements[1].value + "*" + "ACC=ACEPTAR";
				cadena = cadena + document.forms[formulario1].elements[0].value;
			}
			if (document.forms[formulario].elements[1].checked == true){
				var formulario1 = "a" + i;
				cadena = cadena + "{" + document.forms[formulario1].elements[1].value + "*" + "ACC=CANCELAR";
				cadena = cadena + document.forms[formulario1].elements[0].value;
				var formulario2 = "c" + i;
				cadena = cadena + "{" +document.forms[formulario1].elements[1].value + "*" + "MOTIVO_ACCION=" + document.forms[formulario2].elements[0].value;
			}
		}
		document.forms["envio"].elements["param"].value=cadena;
		document.forms["envio"].elements["TAG"].value="SSE_...";
		document.forms["envio"].submit();
	}
}
</script>
<!-- Fin del Requerido para validacion-->
</head>
<body>
<%@ include file="../../mss_generico/espanol/mssgenerico_menusup.jsp" %>
<%@ include file="../../sse_generico/espanol/generico_links.jsp" %>
<%
   String zsubsesion = "ID...";
   String zmeta4object = "ID...";
   String znodo = "ID...";
   String ztipocarga = "SSE";
   String zventanas = "10";
   int zvuelta = 5;
   String zdireccion = "/carpeta/pagina.jsp";
   String zestado="11";
   int zregistroinicial = Integer.valueOf(zinicios).intValue();
   zregistroinicial = zregistroinicial - 1;
   int zventana  = Integer.valueOf(zventanas).intValue();
   int zregistrofinal = zregistroinicial + zventana - 1;
   
   String zoutputdef = zsubsesion + "!" + znodo + "[" + zregistroinicial + "-" + zregistrofinal + "]";
   String zmove =znodo + ":" +  znodo + "[" + zregistroinicial + "]";
   String zraiz = znodo + ":" + zsubsesion + "!" + znodo + ".";
   String zlectura = zsubsesion + "!" + znodo;
   String ziterator = znodo + ":" + zsubsesion + "!" + znodo;
   String zcomun = znodo + ":" + zsubsesion + "!" + znodo + "[&VAR.m4lix]" + ".";

   String znodolista = znodo + "_VAL";
   String zoutputdeflista = zsubsesion + "!" + znodolista + "[*]";
   String zmovelista = znodolista + ":" + znodolista + "[FIRST]";
   String zraizlista = znodolista + ":" + zsubsesion + "!" + znodolista + ".";
   String ziteratorlista = znodolista + ":" + zsubsesion + "!" + znodolista;
   String zcomunlista = znodolista + ":" + zsubsesion + "!" + znodolista + "[&VAR.m4lix]" + ".";
   
   String znodocom = "SSE_COMUNICACION";
   String zoutputdefcom = zsubsesion + "!" + znodocom + "[*]";
   
   String znodoprincipal = "SSE_PRINCIPAL";
   String zmetodocarga = "CARGA:" + zsubsesion + "!" + znodoprincipal + ".CARGA";
   
	String zNOMBREPERSON = zraiz + "NOMBRE_PERSON";	
	
   String zORDINAL =  zcomun+"ORDINAL";
   String zNACCION =zcomun+  "N_ACCION";   
   String zNOMBREEMPLEADO = zcomun+"NOMBRE_EMPLEADO";
   String zSTDEMAIL =  zcomun+"STD_EMAIL";
   String zSTDNLOCATIONTYPE = zcomun+ "STD_N_LOCATION_TYPE";
   
   String zNOMBREEMPLEADOlista = zcomunlista+ "NOMBRE_EMPLEADO";
   String zSTDIDPERSON = zcomunlista+"STD_ID_PERSON";  
%>
<m4:startpage m4task="<%=zsubsesion%>"/><m4:beginjob/>
<m4:datadef m4o="<%=zmeta4object%>" m4name="<%=zsubsesion%>"/>
<%
// Requerido para el filtro de validacion
// Se env�a la informacion sobre el filtro seleccionado:
 try {
	    M4Operations m = new M4Operations(request); 
	    
	    m.setItem(zsubsesion,znodoprincipal,"","NIVEL",znivel);
	    m.setItem(zsubsesion,znodo,"","ID_PERSON",zfiltro);
	      
		} catch(Exception e) {}
<!-- Fin del Requerido para el filtro de validacion-->		
%>
<m4:exec m4method="<%=zmetodocarga%>"><m4:param name="TIPO_CARGA" value="<%=ztipocarga%>"/></m4:exec>
<m4:outputdef m4alias="<%=znodolista%>"><m4:param name="m4name0" value="<%=zoutputdeflista%>"/></m4:outputdef>
<m4:outputdef m4alias="<%=znodocom%>"><m4:param name="m4name0" value="<%=zoutputdefcom%>"/></m4:outputdef >
<m4:outputdef m4alias="<%=znodo%>"><m4:param name="m4name0" value="<%=zoutputdef%>"/></m4:outputdef>
<m4:endjob/>
<m4:move><m4:param name="<%=zsubsesion%>" value="<%=zmove%>"/></m4:move>
<m4:move><m4:param name="<%=zsubsesion%>" value="<%=zmovelista%>"/></m4:move>
<%
	int  zcounti  = 0;
	int  zcountilista  = 0;
	int  zcount  = 0;	
	try {
		M4Operations m = new M4Operations(request);
		zcounti = m.getCountInClient(znodo,zsubsesion,znodo);
		zcountilista = m.getCountInClient(znodolista,zsubsesion,znodolista);
		zcount = m.getCount(znodo,zsubsesion,znodo);
	} catch(Exception e) {}
	String	zcountv = String.valueOf(zcounti);
	String	zcountvlista = String.valueOf(zcountilista);
%>
<table width="100%" cellspacing="0">
<tr>
	<td class="titulofuncional" colspan="2">Valida e-mail</td>
</tr>
<tr>
	<td><img alt="Valida e-mail" src="\iconos\noname_valida_email_79_100.gif" width="79" height="100" /></td>
	<td><div class="descripcionfuncional">Valida los cambios de e-mail de tus empleados.</div></td>
</tr>
</table>
<%@ include file="../../mss_generico/espanol/mssgenerico_filtro_val.jsp" %>
<br />
<!-- Requerido para el filtro de validacion-->
<!-- Formulario de env�o post para el filtro-->
<form action="/servlet/CheckSecurity/JSP/mss_g1/mss_g1_p1_val2.jsp?estado=11" method="post" name="oculto" id="oculto">
<input type="hidden" id="zfiltro" name="zfiltro"  value="<%=zfiltro%>" />
<input type="hidden" id="zfiltroemp" name="znivel"  value="<%=znivel%>" />
<input type="hidden" id="zinicios" name="zinicios"  value="" />
</form>
<!-- Fin Requerido para el filtro de validacion-->
<% if (zcounti > 0) {
	String zregistroinicials = String.valueOf(zregistroinicial);
	String zregistrofinals = String.valueOf(zregistroinicial + zcounti - 1); %>
<table width="100%" cellspacing="0">
<tr><td class="tablaestadosceldatitulo"colspan="2">Peticiones</td></tr>
<%
int zposicion = 0;
String zposicions = "0";
%>
<m4:loop from="<%=zregistroinicials%>" to="<%=zregistrofinals%>">
<%  zposicions = m4lix;
	zposicion = Integer.valueOf(zposicions).intValue();
 	zposicion = zposicion - zregistroinicial;
%>
<tr><td class="fuentecampo">
	<table cellspacing="0" width="100%">
		<tr><td class="fuentecamponombre"><m4:item m4name="<%=zNOMBREEMPLEADO%>" htmlsafe="true"/></td><td class="fuentecampo">&nbsp;solicita :<br /></td><td class="fuentecampoaccion" colspan="2"><m4:item m4name="<%=zNACCION%>" htmlsafe="true"/></td></tr>
		<tr><td class="fuentecamponombre" colspan="4"><br /></td></tr>
		<tr><td class="fuentecampo">E-mail</td><td class="fuentevalor"><m4:item m4name="<%=zSTDEMAIL%>" htmlsafe="true"/></td><td class="fuentecampo">Lugar</td><td class="fuentevalor"><m4:item m4name="<%=zSTDNLOCATIONTYPE%>" htmlsafe="true"/></td></tr>
		<tr><td class="fuentecampo"><form name="a<%=zposicion%>" id="a<%=zposicion%>" action=" "><input id="ocultos<%=zposicion%>" name="ocultos<%=zposicion%>" type="hidden" value="{<m4:item m4name="<%=zORDINAL%>" htmlsafe="true"/>*REC=<m4:item m4name="<%=zORDINAL%>" htmlsafe="true"/>{<m4:item m4name="<%=zORDINAL%>" htmlsafe="true"/>*NOD=SSE_E_MAIL{<m4:item m4name="<%=zORDINAL%>" htmlsafe="true"/>*NIVEL_ACEPTADO=<%=znivel%>" /><input id="ocul<%=zposicion%>" name="<%=zcountv%>" type="hidden" value="<m4:item m4name="<%=zORDINAL%>" htmlsafe="true"/>" /></form></td></tr>
	</table>
	</td>
	<td class="fuentecampo"><form name="b<%=zposicion%>" id="b<%=zposicion%>" action=" "><table cellspacing="0" class="fuentecampo"><tr><td class="fuentecampo"><input id="ac<%=zposicion%>" name="ac<%=zposicion%>" type="checkbox" value="T" onclick="validar(this,document.b<%=zposicion%>.ca<%=zposicion%>)" />Aceptar</td></tr><tr><td class="fuentecampo"><input id="ca<%=zposicion%>" name="ca<%=zposicion%>" type="checkbox" value="T" onclick="validar(this,document.b<%=zposicion%>.ac<%=zposicion%>)" />Cancelar</td></tr></table></form></td>
</tr>
<tr><td class="fuentecampo" colspan="2"><form name="c<%=zposicion%>" id="c<%=zposicion%>" action=" ">Motivo de cancelaci&oacute;n<input size="48" id="mo<%=zposicion%>" name="mo<%=zposicion%>" type="text" maxlength="60" /></form></td></tr>
<tr><td class="separadorlinea" colspan="2"><hr /></td></tr>
</m4:loop>
<tr>
	<td><form id="envio" name="envio" action="/servlet/CheckSecurity/JSP/sse_generico/generico_actualizar_multipeticiones.jsp" method="post"><input type="hidden" id="param" name="param" value="" /><input type="hidden" id="TAG" name="TAG" value="" /></form></td>
</tr>
</table>
<%@include file="../../sse_generico/espanol/generico_ventanas_post.jsp"%>
<%}else{%>
<div class="fuentenodatos">Actualmente no tienes ning&uacute;n dato que validar.</div><br /><br />
<%}%>
<m4:endpage/>
</body>
<%@ include file="../../mss_generico/espanol/mssgenerico_disclaimer.jsp" %>
</div>


