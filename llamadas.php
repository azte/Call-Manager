
<?php
	error_reporting(5);
	include_once "conexion.php";
	session_start();
	if(!isset($_SESSION['usuarioactual']))
		{
			header('location:login.php');
		}
	
?>

<!DOCTYPE html>
<html>

<head>
	<meta cahrset="utf-8">
	<title>CAPTURA DE LLAMADAS</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="stylesheet" type="text/css" href="normalize.css">
	<link href='http://fonts.googleapis.com/css?family=Rosario:400,700' rel='stylesheet' type='text/css'>
	<script src="scripts/f_subtipos.js" language="javascript" type="text/javascript"></script>
	<script src="scripts/validar.js" language="javascript" type="text/javascript"></script>
	<link rel="icon" type="image/png" href="images/favicon.ico" />
<body>
<div class="wrapper">
<style type="text/css">
 body{background-image:url('images/background.jpg');

}
</style>	

<div id="contenido">
<header>
	<h1>CAPTURA DE LLAMADAS</h1>
	<figure>
		<img src="images/logo_tiba.jpg">
	</figure>
	<div id="nombres">

	

	
		<table class="t_datos">
			<tr>
				<td>Fecha:</td><td><input id="date" type="text" disabled></td>
			</tr>
			<tr>
				<td>Nombre del Agente:</td><td><input value="<?php echo $_SESSION[usuarioactual]?>" type="text" disabled></td>
			</tr>
			</tr>
		</table>
	</div>


	
	<div id="login">
		
		<?php
	
	include_once "conexion.php";
	session_start();
	echo "Bienvenid@ "."<strong>".$_SESSION["usuarioactual"]."</strong>";
	 if ($_POST['CerrarSesion']) 
		{
		session_destroy();

    //Y redirecciona
   		 header("Location:login.php"); 
		}

		?>

	<form name="cerrar" method="POST">
	<input type="submit" id="cerrar_sesion" name="CerrarSesion" value="SALIR">
	</form>


	</div>	
</header>
<!------------------SECCIÓN QUE MUESTRA LOS REPORTES DE BASE DE DATOS-------------->	
	<div id="reportes">
	
		

		<?php
// Conectando, seleccionando la base de datos
		$link = mysql_connect('localhost', 'root', '*mayuda01*')
    	or die('No se pudo conectar: ' . mysql_error());

		mysql_select_db('prueba') or die('No se pudo seleccionar la base de datos'); //BD PRUEBAS


//Cuantos reportes llevas

		$querycontar="SELECT count(idr) as reportes,usuario,tienda,comentarios,ticket,reportes.tipo,subtipo,fecha,hora from reportes,usuarios where fecha=curdate() and idu=id_u and nombre='$_SESSION[usuarioactual]'";
		$rtotal=mysql_query($querycontar);
		$reportes = mysql_fetch_assoc($rtotal);

		echo "<span>"."Reportes: ".$reportes['reportes']."</span>";

// Realizar una consulta MySQL
		$query = "SELECT idr,usuario,tienda,comentarios,ticket,reportes.tipo,subtipo,fecha,hora from reportes,usuarios where fecha=curdate() and idu=id_u and nombre='$_SESSION[usuarioactual]'"; //TABLA SELECCIONADA Y QUERY
		$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());

// Imprimir los resultados en HTML

		echo "<table id=t_consulta>\n";
		echo "<tr id=encabezado_consulta><td>Reporte</td><td>Usuario</td><td>Tienda</td><td>Comentarios</td><td width=60>Ticket</td><td>Tipo</td><td>Subtipo</td><td width=90>Fecha</td><td width=90>Hora</td></tr>";
			
		//Mientras existe un renglon de resultados, va generar un renglon de tabla y lo separa con TD

			while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
   				 echo "\t<tr>\n";
    	foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
   		 }
    		echo "\t</tr>\n";
		}
		echo "</table>\n";

// Liberar resultados
		mysql_free_result($result);

// Cerrar la conexión
		mysql_close($link);
		?>
	
	</div>
<!-- SCRIPT AÑADIR FECHA FORMATO MYSQL YYYY-MM-DD -->

<script type="text/javascript">

	var f = new Date();

	document.getElementById('date').value=f.getFullYear()+"-"+(f.getMonth()+1)+"-"+f.getDate();


</script>

<section>
<!--****************FORMULARIO DE CAPTURA****************-->
	<form action="genera_r.php" method="post" onsubmit="return valida()" name="captura">
		<table class="t_reportes">
			<tr>

				<td class="t_encabezado">Usuario</td>
				<td class="t_encabezado" size="50">Tienda | Corp</td>
				<td class="t_encabezado">Comentarios</td>
				<td class="t_encabezado">Ticket</td> <!--ENCABEZADO DE TICKET-->
				<td class="t_encabezado">Tipo de Llamada</td>
				<td class="t_encabezado">Subtipo</td>
				<td rowspan="2" class="t_encabezado">
					<input class="button" type="submit" name="ok" id="ok"value="Guardar">
				</td>	


			</tr>
			<tr>

				<td class="t_encabezado"><input id="usuario" placeholder="Nombre"name="usuario" type="text"></td>	
				<td class="t_encabezado"><input id="tienda" name="tienda" placeholder="Tienda" type="text"></td>
				<td class="t_encabezado"><textarea name="comentarios" rows="1" cols="20"></textarea></td>
				<td class="t_encabezado"><input id="ticket" name="ticket" type="text"></td>	
				<td class="t_encabezado">
					<select name="tipo" id="tipo" onchange="cambia_subtipo()">
						<option value="Seleccione" selected>Seleccione</option>
						<option value="Seguimiento">Seguimiento</option>
						<option value="Abandonada">Abandonada</option>
						<option value="Cortada">Cortada</option>
						<option value="Informes">Informes</option>
						<option value="Transferencia">Transferencia</option>
						<option value="Ticket Informativo">Ticket Informativo</option>
						<option value="Incidente">Incidente</option>
						<option value="Requerimiento">Requerimiento</option>



					</select>
				</td>	

				<td class="t_encabezado"> 
					<select id="informes" name="subtipo">
						<option  value="-">-</option>


					</select>

				</td>

			</tr>



		</table>
	</form>
</section>




<!--SCRIPT MANIPULAR TIPO Y SUBTIPO DE LLAMADAS-->
</div>
</div>

</body>	
</html>	