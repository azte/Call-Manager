


<?php

//Esta linea es para incluir el archivo con las variables


/* CONECTAR CON BASE DE DATOS **************** */
$link = mysql_connect('localhost', 'root', '')
or die('No se pudo conectar: ' . mysql_error());

mysql_select_db('prueba') or die('No se pudo seleccionar la base de datos'); 

$fecha=date("y/m/d");
$query = "INSERT INTO reportes(idr,usuario,tienda,comentarios,tipo,subtipo,fecha) values(null,'$_POST[usuario]','$_POST[tienda]',
	'$_POST[comentarios]','$_POST[tipo]','$_POST[subtipo]','$fecha')";
$result = mysql_query($query);

if (! $result){

echo "La consulta SQL contiene errores.".mysql_error();

exit();

}else {

	echo "<font color='RED'>DATOS INSERTADOS CORRECTAMENTE";

}

?>

<script type="text/javascript">

	
alert("Reporte Registrado")
window.location="http://localhost/issste/llamadas.php"

</script>