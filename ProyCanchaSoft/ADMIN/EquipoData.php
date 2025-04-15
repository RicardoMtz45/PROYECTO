<?php
header('Content-Type: application/json');
include("../LOGIN/ConexionLogin.php");

$resultado = [];

if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];

    // Preparamos la consulta con LIKE para permitir coincidencias parciales
    $stmt = $mysqli->prepare("SELECT Id_Equipo, Nom_Equipo, Color_Uniforme, Id_Capitan FROM equipo WHERE Nom_Equipo LIKE ? LIMIT 1");

    if ($stmt) {
        $busqueda = "%" . $nombre . "%";
        $stmt->bind_param("s", $busqueda);
        $stmt->execute();
        $stmt->bind_result($id, $nom_equipo, $color_uniforme, $id_capitan);

        if ($stmt->fetch()) {
            $resultado = [
                "id_equipo" => $id,
                "nom_equipo" => $nom_equipo,  // Devolviendo el nombre del equipo desde la base de datos
                "color_uniforme" => $color_uniforme,
                "id_capitan" => $id_capitan
            ];
        } else {
            $resultado = ["error" => "No se encontró el equipo."];
        }

        $stmt->close();
    } else {
        $resultado = ["error" => "Error al preparar la consulta."];
    }
} else {
    $resultado = ["error" => "No se especificó un nombre de equipo."];
}

$mysqli->close();
echo json_encode($resultado);
?>
