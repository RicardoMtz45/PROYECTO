<?php 
header('Content-Type: application/json; charset=utf-8');
include("../LOGIN/ConexionLogin.php");
include("DatosEquipo.php");

$postBody = file_get_contents("php://input");
$data = isset($postBody) ? json_decode($postBody) : null;

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        _get();
        break;
    case 'POST':
        _post($data);
        break;
    default:
        header('HTTP/1.1 405 Method Not Allowed');
        header('Allow: GET, POST');
        echo json_encode(["error" => "Método no permitido"]);
        break;
}

function _get() {
    global $mysqli;
    $respuesta = [];

    if (!$mysqli) {
        echo json_encode(["error" => "No se pudo conectar a la base de datos."]);
        return;
    }

    try {
        if (isset($_GET['nombre'])) {
            $nombre = "%" . $_GET['nombre'] . "%";
            $stmt = $mysqli->prepare("SELECT Id_Equipo, Nom_Equipo, Color_Uniforme, Id_Capitan FROM equipo WHERE Nom_Equipo LIKE ?");
            $stmt->bind_param("s", $nombre);
        } else {
            $stmt = $mysqli->prepare("SELECT Id_Equipo, Nom_Equipo, Color_Uniforme, Id_Capitan FROM equipo");
        }

        if ($stmt) {
            $stmt->execute();
            $stmt->bind_result($id_Equipo, $Nom_Equipo, $Color_Uniforme, $id_Capitan);

            while ($stmt->fetch()) {
                $equipo = new Equipo(
                    $id_Equipo,
                    $Nom_Equipo,
                    $Color_Uniforme,
                    $id_Capitan
                );
                $respuesta[] = $equipo;
            }

            $stmt->close();
        } else {
            echo json_encode(["error" => "Error al preparar la consulta."]);
            return;
        }
    } catch (Exception $e) {
        echo json_encode(["error" => "Excepción: " . $e->getMessage()]);
        return;
    } finally {
        if ($mysqli) {
            $mysqli->close();
        }
    }

    echo json_encode($respuesta);
}


function _post($data) {
    global $mysqli;

    if (!$mysqli) {
        echo json_encode(["error" => "No se pudo conectar a la base de datos."]);
        return;
    }

    if (isset($data->Nom_Equipo, $data->Color_Uniforme, $data->Id_Capitan)) {
        try {
            $stmt = $mysqli->prepare("INSERT INTO equipo (Nom_Equipo, Color_Uniforme, Id_Capitan) VALUES (?, ?, ?)");

            if ($stmt) {
                $stmt->bind_param("ssi", 
                    $data->Nom_Equipo,
                    $data->Color_Uniforme,
                    $data->Id_Capitan
                );

                if ($stmt->execute()) {
                    echo json_encode(["success" => true, "message" => "Equipo registrado correctamente"]);
                } else {
                    echo json_encode(["success" => false, "error" => "Error al insertar el equipo"]);
                }

                $stmt->close();
            } else {
                echo json_encode(["error" => "Error al preparar la consulta."]);
            }
        } catch (Exception $e) {
            echo json_encode(["error" => "Excepción: " . $e->getMessage()]);
        } finally {
            if ($mysqli) {
                $mysqli->close();
            }
        }
    } else {
        echo json_encode(["error" => "Faltan datos para crear el equipo (Nom_Equipo, Color_Uniforme, Id_Capitan requeridos)."]);
    }
}
?>
