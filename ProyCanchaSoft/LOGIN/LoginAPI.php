<?php
header('Content-Type: application/json; charset=utf-8');
include("ConexionLogin.php"); // Asegúrate que esta conexión funcione

$postBody = file_get_contents("php://input");
$data = json_decode($postBody);

if (!isset($data->Correo, $data->Contraseña)) {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
    exit;
}

$correo = $data->Correo;
$contrasena = $data->Contraseña;

$stmt = $mysqli->prepare("SELECT Id_Usuario FROM Usuario WHERE Correo = ? AND Contraseña = ?");
$stmt->bind_param("ss", $correo, $contrasena);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["success" => true, "message" => "Acceso concedido"]);
} else {
    echo json_encode(["success" => false, "message" => "Correo o contraseña incorrectos"]);
}

$stmt->close();
$mysqli->close();
?>
