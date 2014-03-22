<?php
// Conectando, seleccionando la base de datos
		$link = mysql_connect('localhost', 'root', '')
    	or die('No se pudo conectar: ' . mysql_error());

		mysql_select_db('prueba') or die('No se pudo seleccionar la base de datos'); //BD PRUEBAS


	 /* El query valida si el usuario ingresado existe en la base de datos. Se utiliza la función 
     htmlentities para evitar inyecciones SQL. */
     $myusuario = mysql_query("SELECT nombre FROM Usuarios 
                                 WHERE nombre =  '".htmlentities($_POST["usuario"])."'",$link);
     $nmyusuario = mysql_num_rows($myusuario);

     //Si existe el usuario, validamos también la contraseña ingresada y el estado del usuario...
     if($nmyusuario != 0){
          $sql = "SELECT Nombre
               FROM usuarios
               WHERE nombre = '".htmlentities($_POST["usuario"])."' 
               and password = '".md5(htmlentities($_POST[("clave")]))."'";
          $myclave = mysql_query($sql,$link);
          $nmyclave = mysql_num_rows($myclave);

          //Si el usuario y clave ingresado son correctos (y el usuario está activo en la BD), creamos la sesión del mismo.
          if($nmyclave != 0){
               session_start();
               //Guardamos dos variables de sesión que nos auxiliará para saber si se está o no "logueado" un usuario
               $_SESSION["autentica"] = "SIP";
               $_SESSION["usuarioactual"] = mysql_result($myclave,0,0); //nombre del usuario logueado.
			   $_SESSION["tipo"] = tipo_usuario($_POST["usuario"]);
			    // Buscamos que tipo es.
			   
						if($_SESSION['tipo']="1")
								header("location:llamadas.php");
						else
								header("location:home.php");
               //Direccionamos a nuestra página principal del sistema.
              
          }
          else{
               echo"<script>alert('La contrase\u00f1a del usuario no es correcta.');
               window.location.href=\"login.php\"</script>"; 
          }
     }else{
          echo"<script>alert('El usuario no existe.');window.location.href=\"index.php\"</script>";
     }
	 
	 function tipo_usuario($user)
    {
        $sql = "SELECT tipo FROM Usuario WHERE Nombre='$user'";
		$rec = mysql_query($sql);
		while($row = mysql_fetch_assoc($rec))
        {
            $result = $row['tipo'];
        }
		return $result;
    }
     mysql_close($link);
	
     
?>
