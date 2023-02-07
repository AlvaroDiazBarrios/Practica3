<?php include("header.php");?>
<?php
session_start();

include 'conexionbd.php';

$conn=conexion();

// Genera un número aleatorio entre 1 y 100 y lo guarda en la sesión
if (!isset($_SESSION['random_number'])) {
    $_SESSION['random_number'] = rand(1, 100);
}


// Inicializa los límites para el juego
$lower_limit = 1;
$upper_limit = 100;


if(!isset($_SESSION['upper_limit'])){
    $_SESSION['upper_limit'] = 100;
}
if(!isset($_SESSION['lower_limit'])){
    $_SESSION['lower_limit'] = 1;
}


// Contador de intentos
$attempts = 0;

// Verifica si se ha enviado un número por POST
if (isset($_POST['number'])) {
    $number = $_POST['number'];
    $attempts = $_SESSION['attempts'];

    // Verifica si el número es mayor, menor o igual al número aleatorio
    if ($number > $_SESSION['random_number']) {
        $_SESSION['upper_limit'] = $number - 1;
        $attempts++;
    } elseif ($number < $_SESSION['random_number']) {
        $_SESSION['lower_limit'] = $number + 1;
        $attempts++;
    } else {
        // El número es igual al número aleatorio
        $attempts++;
        header("location:./rankings.php");
        
        echo "¡Felicidades, has adivinado el número en $attempts intentos!";
        // Verifica si supera el récord y lo guarda en la base de datos
        if ($attempts < $_SESSION['intentos'] or $_SESSION['intentos'] == 0) {
           
            $date = date('Y-m-d');
            $victorias = $_SESSION['victorias'] + 1;
            $sql = 'UPDATE USUARIOS SET INTENTOS = '  . $attempts . ', FECHA_RECORD = "' . $date . '", GANADAS  = ' . $victorias .  ' where EMAIL ="' . $_SESSION['email'] . '";';
            echo $sql;
            $resultado=mysqli_query($conn, $sql);
            echo "Resultado de query: {$resultado}";
            mysqli_close($conn);
                
            
            // Conexión a la base de datos y guardado del récord aquí
        }
        ob_end_clean();    
        

        // Finaliza el juego
        unset($_SESSION['random_number']);
        unset($_SESSION['attempts']);
        exit;
    }

    // Guarda el número de intentos en la sesión
    $_SESSION['attempts'] = $attempts;
}
?>

<!DOCTYPE html>
<html>
<body>
    <div class ="main">
        <h1>Juego del número</h1>
        <p>Intenta adivinar el número entre <?php echo $_SESSION['lower_limit']; ?> y <?php echo $_SESSION['upper_limit']; ?></p>
        <p><?php echo $number;?> </p>
        <p><?php echo $_SESSION['random_number'];?> </p>
        <p><?php echo $_SESSION['intentos'];?> </p>
        <p><?php echo $_SESSION['nombre'];?> </p>
        <form action="" method="post">
            <input type="number" name="number">
            <input type="submit" value="Enviar">
    </form>
</body>
</html>
