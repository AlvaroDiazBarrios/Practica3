<?php session_start(); ?>
<link rel="stylesheet" href="css/cabecera.css" />
<header>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="juego.php">Jugar</a>
        <a href="inicioSesion.php"><?php echo $_SESSION['nombre'];?></a>
    </nav>
</header>
