<?php
	include 'conexionbd.php';
    session_start();

	$error = FALSE;
	$email = 'class="entrada_datos"';

	if (isset($_POST['comprobacion'])) {
    

		if (isset($_POST['email'])) {
			if ($_POST['email'] == "")
			{
                $error = TRUE;
                echo "<script>
                        var peticion = confirm('No ha introducido Correo');
                        console.log(peticion);
                    </script>";
			}
		}

		if ($error == FALSE)
		{
			comprobar_usuario($_POST['email']);
		}
	}

	function mostrar_campo($nombre)
	{
		global $error;
		if ($error == TRUE)
		{
			echo('"' . $_POST[$nombre] . '"');
		}
		else
		{	
			echo('""');
		}
	}
	
	
	function comprobar_usuario($email)
	{
		$con=conexion();
		$sql="select count(*) as total from USUARIOS where email='" . $email ."';";
        $resultado=mysqli_query($con, $sql);
        $datos=mysqli_fetch_assoc($resultado);
        $cantidad = $datos['total'];
        
        if ($cantidad == 0) {
            $error = TRUE;
            echo "<script>
                        var peticion = confirm('Usuario inexistente');
                        console.log(peticion);
                    </script>";
        }
        else {
                $jug = obtener_datos_usuario($email);
                $_SESSION['nombre']=$jug['nombre'];
                $_SESSION['email']=$jug['email'];
                $_SESSION['apellido']=$jug['apellido'];
                $_SESSION['intentos']=$jug['intentos'];
                $_SESSION['fecha_record'] = $jug['fecha_record'];
                $_SESSION['victorias']=$jug['IFNULL(ganadas,0)'];
                $_SESSION['perdidas']=$jug['IFNULL(perdidas,0)'];
                $_SESSION['jugando']=false;
                $_SESSION['sesionJuego']=true;
                header("location: ./juego.php");
        }
	}
	
	function obtener_datos_usuario($email)
	{
		$con=conexion();

		$sql="select email, nombre, intentos, fecha_record, fecha_nacimiento, apellido, IFNULL(ganadas,0), IFNULL(perdidas,0) from USUARIOS where email = '" . $email . "';";
		$resultado=mysqli_query($con, $sql);
        $datos=mysqli_fetch_assoc($resultado);
        
		mysqli_close($con);
		
		return $datos;
	}

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/alta.css" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Bebas+Neue&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Solway&display=swap" rel="stylesheet">
        <title>Conexi??n</title>
    </head>

    <body>
        <form action="./inicioSesion.php" method="post">
			<div>
				<fieldset id="formulario_alta">
					<legend id="hola">Conexi??n</legend>
					<table>
						<tr>
							<td>
								<p>Email</p>
								<input id="email" type="text" name="email" <?php echo($email); ?> value=<?php mostrar_campo('email'); ?>/>
							</td>
						</tr>
					</table>
					<div id="caja_boton">
						<input id="enviar" type="submit" value="Conectarse">
					</div>
				</fieldset>
			</div>
			<input id="comprobacion" type="hidden" name="comprobacion" value="ok" />
        </form>
    </body>
</html>
