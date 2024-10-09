<?php
session_start(); // Iniciar la sesión
include 'conexion.php'; // Incluir archivo de conexión

// Definir el límite de intentos
$attemptLimit = 5;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consultar los intentos de inicio de sesión previos
    $sql = "SELECT attempts, last_attempt FROM login_attempts WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($attempts, $lastAttempt);
    $stmt->fetch();

    $currentTimestamp = new DateTime();
    if ($attempts >= $attemptLimit) {
        $lastAttemptTimestamp = new DateTime($lastAttempt);
        $timeDiff = $currentTimestamp->diff($lastAttemptTimestamp);
        
        // Bloquear el acceso si han pasado menos de 15 minutos desde el último intento
        if ($timeDiff->i < 15) {
            die("Demasiados intentos fallidos. Por favor, intente de nuevo más tarde.");
        } else {
            // Reiniciar intentos si han pasado más de 15 minutos
            $attempts = 0;
            $sql = "DELETE FROM login_attempts WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
        }
    }

    // Consultar el usuario en la tabla 'login'
    $sql = "SELECT * FROM login WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            // Guardar el nombre de usuario en la sesión
            $_SESSION['username'] = $username;
            // Redirigir a 'dashboard.html'
            header("Location: dashboard.html");
            exit();
        } else {
            // Incrementar el contador de intentos
            $attempts++;
            $sql = "INSERT INTO login_attempts (username, attempts, last_attempt) VALUES (?, ?, CURRENT_TIMESTAMP)
                    ON DUPLICATE KEY UPDATE attempts = ?, last_attempt = CURRENT_TIMESTAMP";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sii", $username, $attempts, $attempts);
            $stmt->execute();
            echo "Contraseña incorrecta. Intentos restantes: " . ($attemptLimit - $attempts);
        }
    } else {
        echo "Usuario no encontrado.";
    }

    $stmt->close();
}
$conn->close();
?>

