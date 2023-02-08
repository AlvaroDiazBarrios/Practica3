<?php
// Inicio de sesión
session_start();

include 'conexionbd.php';
include 'header.php';
// Verifica la conexión
$conn = conexion();

if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Consulta a la base de datos para obtener los intentos y las fechas de todos los usuarios
$sql = "SELECT NOMBRE, INTENTOS, FECHA_RECORD FROM USUARIOS WHERE INTENTOS IS NOT NULL AND INTENTOS <> 0 ORDER BY INTENTOS, FECHA_RECORD DESC";
$result = mysqli_query($conn, $sql);

$i = 0;
// Verifica si hay resultados
if (!empty($result) AND mysqli_num_rows($result) > 0) {
    // Muestra la lista de clasificaciones
    echo "<h1>Clasificaciones</h1>";
    echo "<table text-align='center'>";
    echo "<tr><th>Rango</th><th>Usuario&nbsp;&nbsp;</th><th>Intentos&nbsp;</th><th>Fecha</th></tr>";
    // Recorre cada fila de resultados
    while($row = mysqli_fetch_assoc($result)) {
        $i++;
        echo "<tr><td>".$i."</td><td>" . $row["NOMBRE"]. "</td><td>" . $row["INTENTOS"]. "</td><td>" . $row["FECHA_RECORD"]. "</td></tr>";
    }
    echo "</table>";
} else {
    // No hay resultados
    echo "No se encontraron clasificaciones";
}

// Cierra la conexión a la base de datos
mysqli_close($conn);
?>
