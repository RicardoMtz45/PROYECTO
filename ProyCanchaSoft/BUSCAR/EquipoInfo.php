<?php
include("../LOGIN/ConexionLogin.php");

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $nombre = trim($_GET['search']);
    $nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');

    // Preparar la consulta SQL con comodín
    $stmt = $mysqli->prepare("SELECT Id_Equipo, Nom_Equipo, Color_Uniforme, Id_Capitan FROM equipo WHERE Nom_Equipo LIKE ?");
    
    if ($stmt === false) {
        echo '<div class="alert alert-danger text-center mt-5">Error al preparar la consulta.</div>';
        exit();
    }

    $like = "%$nombre%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        echo '<div class="container mt-4">';
        while ($equipo = $resultado->fetch_assoc()) {
            echo '
                <div class="card mb-3 shadow">
                    <div class="card-header bg-success text-white">
                        ' . htmlspecialchars($equipo['Nom_Equipo']) . '
                    </div>
                    <div class="card-body">
                        <p><strong>Capitán ID:</strong> ' . htmlspecialchars($equipo['Id_Capitan'] ?? 'No disponible') . '</p>
                        <p><strong>Color del uniforme:</strong> ' . htmlspecialchars($equipo['Color_Uniforme'] ?? 'No especificado') . '</p>
                    </div>
                </div>
            ';
        }
        echo '</div>';
    } else {
        echo '<div class="alert alert-warning text-center mt-5">No se encontró ningún equipo con ese nombre.</div>';
    }

    $stmt->close();
} else {
    echo '<div class="alert alert-danger text-center mt-5">Por favor ingresa un nombre de equipo válido.</div>';
}

$mysqli->close();
?>
