<?php

//Esta linea es para incluir el archivo con las variables


/* CONECTAR CON BASE DE DATOS **************** */
$link = mysql_connect('localhost', 'root', '*mayuda01*')
or die('No se pudo conectar: ' . mysql_error());

mysql_select_db('prueba') or die('No se pudo seleccionar la base de datos'); 


session_start();


$consulta="SELECT idu from usuarios where nombre='$_SESSION[usuarioactual]'";
$idr=mysql_query($consulta);
$resEmp = mysql_fetch_assoc($idr);
   //echo $resEmp['idu']."<br>";

$tiendaquery="SELECT det from datos where det='$_POST[tienda]'";
$resultadotienda=mysql_query($tiendaquery); 
$tienda=mysql_fetch_assoc($resultadotienda);

if (($tienda['det'])!=($_POST['tienda'])) 
{ 

echo "LA TIENDA "."<strong>"."$_POST[tienda]"."</strong>"." NO EXISTE, REVISA EL DIRECTORIO.".mysql_error(); 
exit();

}

else{

}

date_default_timezone_set("America/Mexico_City");
$fecha=date("y/m/d");

$query = "INSERT INTO reportes(id_u,usuario,tienda,comentarios,ticket,tipo,subtipo,fecha,hora) values('$resEmp[idu]','$_POST[usuario]','$_POST[tienda]',
	'$_POST[comentarios]','$_POST[ticket]','$_POST[tipo]','$_POST[subtipo]',curdate(),curtime())";
$result = mysql_query($query);

if (! $result){

echo "La consulta SQL contiene errores.".mysql_error();

exit();

}else {

	

}

?>

	<script type="text/javascript">
	
		
	alert("REPORTE REGISTRADO CORRECTAMENTE")
	window.location="http://192.163.161.137/call-manager/llamadas.php"
	
	</script>


