<?php

//Esta linea es para incluir el archivo con las variables


/* CONECTAR CON BASE DE DATOS **************** */
$link = mysql_connect('localhost', 'root', '')
or die('No se pudo conectar: ' . mysql_error());

mysql_select_db('prueba') or die('No se pudo seleccionar la base de datos'); 


session_start();


$consulta="SELECT idu from usuarios where nombre='$_SESSION[usuarioactual]'";
$idr=mysql_query($consulta);
$resEmp = mysql_fetch_assoc($idr);
   //echo $resEmp['idu']."<br>";

$fecha=date("y/m/d");
$query = "INSERT INTO reportes(id_u,usuario,tienda,comentarios,tipo,subtipo,fecha) values('$resEmp[idu]','$_POST[usuario]','$_POST[tienda]',
	'$_POST[comentarios]','$_POST[tipo]','$_POST[subtipo]','$fecha')";
$result = mysql_query($query);

if (! $result){

echo "La consulta SQL contiene errores.".mysql_error();

exit();

}else {

	

}

?>

	<script type="text/javascript">
	
		
	alert("REPORTE REGISTRADO CORRECTAMENTE")
	window.location="http://localhost/call-manager/llamadas.php"
	
	</script>


