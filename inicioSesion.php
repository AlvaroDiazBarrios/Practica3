
<?php

	include 'conexionbd.php';

	$error = FALSE;
	$email = 'class="entrada_datos"';

	if (isset($_POST['comprobacion'])) {
    

		if (isset($_POST['email'])) {
			if (comprobar_introduccion_string_vacio($_POST['email']) == TRUE)
			{
				$error = TRUE;
				$email = 'class="entrada_datos error"';
			}
		}

		if ($error == FALSE)
		{
			comprobar_usuario($_POST['email']);
			header("location:./index.php");
		}
	}
	
	function comprobar_introduccion_string_vacio($campo)
    {
		$error = comprobar_sql_injection($campo);
		if ($error == FALSE)
		{
			if (strlen($campo) > 100)
			{
				$error = TRUE;
			}
		}
        return $error;
    }

	function comprobar_sql_injection($valor)
	{
		$error = FALSE;
		if (strpos($valor, "'") == TRUE) {
			$error = TRUE;
		}
		else if (strpos($valor, '"') == TRUE)
		{
			$error = TRUE;
		}
		else if (strpos($valor, ';') == TRUE)
		{
			$error = TRUE;
		}
		else if (strpos($valor, '<') == TRUE)
		{
			$error = TRUE;
		}
		else if (strpos($valor, '>') == TRUE)
		{
			$error = TRUE;
		}
		else if (strpos($valor, '/') == TRUE)
		{
			$error = TRUE;
		}
		else if (strpos($valor, '&') == TRUE)
		{
			$error = TRUE;
		}
		else if (strpos($valor, '--') == TRUE)
		{
			$error = TRUE;
		}
		else if (strpos($valor, '/*') == TRUE)
		{
			$error = TRUE;
		}
		else if (strpos($valor, '*/') == TRUE)
		{
			$error = TRUE;
		}
		return $error;
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
		$sql='select count(*) from usuarios where email = ' . $email . ';';
		$resultado=mysqli_query($con, $sql);
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
        <title>Conexión</title>
    </head>

    <body>
        <form action="./inicioSesion.php" method="post">
			<div>
				<fieldset id="formulario_alta">
					<legend id="hola">Conexión</legend>
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
