<?php
session_start(); // Iniciar la sesión
include 'conexion.php'; // Incluir archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consultar el usuario en la tabla 'login'
    $sql = "SELECT * FROM login WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar si la cuenta está bloqueada
        if ($row['tiempo_bloqueo'] && strtotime($row['tiempo_bloqueo']) > time()) {
            die('Cuenta bloqueada. Intenta de nuevo más tarde.');
        }

        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            // Reiniciar intentos fallidos y tiempo de bloqueo
            $update = "UPDATE login SET intentos_fallidos = 0, tiempo_bloqueo = NULL WHERE id = ?";
            $stmt = $conn->prepare($update);
            $stmt->bind_param("i", $row['id']);
            $stmt->execute();
            
            // Guardar el nombre de usuario en la sesión
            $_SESSION['username'] = $username;
            // Redirigir a 'dashboard.html'
            header("Location: dashboard.html");
            exit();
        } else {
            // Incrementar intentos fallidos
            $attempts = $row['intentos_fallidos'] + 1;

            // Bloquear la cuenta si excede el límite
            if ($attempts >= 5) {
                // Establecer el tiempo de bloqueo (15 minutos)
                $update = "UPDATE login SET tiempo_bloqueo = NOW() + INTERVAL 15 MINUTE, intentos_fallidos = ? WHERE id = ?";
                $stmt = $conn->prepare($update);
                $stmt->bind_param("ii", $attempts, $row['id']);
                $stmt->execute();
                die('Cuenta bloqueada por 15 minutos debido a múltiples intentos fallidos.');
            } else {
                // Actualizar intentos fallidos
                $update = "UPDATE login SET intentos_fallidos = ? WHERE id = ?";
                $stmt = $conn->prepare($update);
                $stmt->bind_param("ii", $attempts, $row['id']);
                $stmt->execute();
                echo 'Contraseña incorrecta. Intentos fallidos: ' . $attempts;
            }
        }
    } else {
        echo "Usuario no encontrado.";
    }

    $stmt->close();
    $conn->close();
}
?>
