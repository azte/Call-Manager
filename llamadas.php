
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
	<script src="scripts/f_subtipos.js" language="javascript" type="text/javascript"></script>
	<script src="scripts/validar.js" language="javascript" type="text/javascript"></script>
<body>
<div id="contenido">
<header>
	<h1>CAPTURA DE LLAMADAS</h1>
	<figure>
		<img src="images/logo_tiba.jpg">
	</figure>
	<div id="nombres">

	

	
		<table class="t_datos">
			<tr>
				<td>Fecha:</td><td><input id="date" type="text"></td>
			</tr>
			<tr>
				<td>Nombre del Agente:</td><td><input value="<?php echo $_SESSION[usuarioactual]?>" type="text"></td>
			</tr>
			</tr>
		</table>
	</div>


	
	<div id="login">
		
		<?php
	
	include_once "conexion.php";
	session_start();
	echo "Bienvenido ".$_SESSION["usuarioactual"];
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
	
		<span>Reportes</span>

		<?php
// Conectando, seleccionando la base de datos
		$link = mysql_connect('localhost', 'root', '')
    	or die('No se pudo conectar: ' . mysql_error());

		mysql_select_db('prueba') or die('No se pudo seleccionar la base de datos'); //BD PRUEBAS

// Realizar una consulta MySQL
		$query = "SELECT idr,usuario,tienda,comentarios,ticket,reportes.tipo,subtipo,fecha from reportes,usuarios where fecha=curdate() and idu=id_u and nombre='$_SESSION[usuarioactual]'"; //TABLA SELECCIONADA Y QUERY
		$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());

// Imprimir los resultados en HTML

		echo "<table id=t_consulta border=1>\n";
		echo "<tr id=encabezado_consulta><td>Reporte</td><td>Usuario</td><td>Tienda</td><td>Comentarios</td><td>Ticket</td><td>Tipo</td><td>Subtipo</td><td width=90>Fecha</td></tr>";
			
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
	document.getElementById('date').value=f.getFullYear()+"-"+f.getMonth()+"-"+f.getDate();


</script>

<section>
<!--****************FORMULARIO DE CAPTURA****************-->
	<form action="genera_r.php" method="post" onsubmit="return valida()" name="captura">
		<table class="t_reportes">
			<tr>

				<td class="t_encabezado">Usuario</td>
				<td class="t_encabezado" size="50">Tienda/Depto/Corp</td>
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
				<td class="t_encabezado"><input name="tienda" placeholder="Tienda" type="text"></td>
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
</body>	
</html>	