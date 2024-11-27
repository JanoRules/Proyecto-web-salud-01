<?php
session_start();
include 'conexion.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta para verificar el usuario
    $sql = "SELECT * FROM login WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar si la cuenta está bloqueada
        if ($row['tiempo_bloqueo'] && strtotime($row['tiempo_bloqueo']) > time()) {
            $error_message = 'Cuenta bloqueada. Intenta de nuevo más tarde.';
        } elseif (password_verify($password, $row['password'])) {
            // Restablecer intentos fallidos
            $update = "UPDATE login SET intentos_fallidos = 0, tiempo_bloqueo = NULL WHERE id = ?";
            $stmt = $conn->prepare($update);
            $stmt->bind_param("i", $row['id']);
            $stmt->execute();

            // Iniciar sesión
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];
            $_SESSION['rut'] = $row['rut']; // Almacenar el rut en la sesión

            // Redirigir según el rol
            if ($row['role'] === 'admin') {
                header("Location: admin-dashboard.html");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            // Contraseña incorrecta
            $error_message = 'Usuario o contraseña incorrecta.';
        }
    } else {
        // Usuario no encontrado
        $error_message = 'Usuario o contraseña incorrecta.';
    }

    $stmt->close();
}
$conn->close();
?>





