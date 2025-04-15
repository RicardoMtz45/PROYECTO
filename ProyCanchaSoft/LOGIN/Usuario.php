<?php 
header('Content-Type: application/json; charset=utf-8');
include("ConexionLogin.php");
include("DatosUsuario.php");

$postBody = file_get_contents("php://input");

if(isset($postBody)) $data = json_decode($postBody);
else $data = null;

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
        break;
}

function _get() {
    global $mysqli; // <- Esto es CLAVE para usar la conexión creada en ConexionLogin.php

    $respuesta = [];

    if (!$mysqli) {
        echo json_encode(["error" => "No se pudo conectar a la base de datos."]);
        return;
    }

    try {
        // Asegúrate de que esta consulta es correcta
        $stmt = $mysqli->prepare("SELECT Id_Usuario, Nombres, Apellidos, Correo, Contraseña, Posicion FROM Usuario");

        if ($stmt) {
            $stmt->execute();
            $stmt->bind_result($id, $nombres, $apellidos, $correo, $contrasena, $posicion);

            // Usar la variable $id dentro del fetch
            $respuesta = [];
            while ($stmt->fetch()) {
                // Aquí $id es válido
                $usuario = new Usuario($id, $nombres, $apellidos, $correo, $contrasena, $posicion);
                array_push($respuesta, $usuario);
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

    // Verificar si los datos necesarios están presentes
    if (isset($data->Nombres, $data->Apellidos, $data->Correo, $data->Contraseña, $data->Posicion)) {
        try {
            // Preparar la consulta para insertar el usuario
            $stmt = $mysqli->prepare("INSERT INTO Usuario (Nombres, Apellidos, Correo, Contraseña, Posicion) VALUES (?, ?, ?, ?, ?)");

            if ($stmt) {
                $stmt->bind_param("sssss", $data->Nombres, $data->Apellidos, $data->Correo, $data->Contraseña, $data->Posicion);
                
                if ($stmt->execute()) {
                    echo json_encode(["success" => true, "message" => "Usuario registrado correctamente"]);
                } else {
                    echo json_encode(["success" => false, "error" => "Error al insertar el usuario"]);
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
        echo json_encode(["error" => "Faltan datos para crear el usuario."]);
    }
}
?>

