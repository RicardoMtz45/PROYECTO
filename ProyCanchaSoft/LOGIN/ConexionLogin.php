<?php
$mysqli = new mysqli("127.0.0.1", "root", "Antoniomtz45", "canchasoft");

if ($mysqli->connect_errno) {
    die("Error de conexión a la base de datos: " . $mysqli_connect_error);
}

?>