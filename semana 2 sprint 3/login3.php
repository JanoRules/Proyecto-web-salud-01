<?php
session_start(); // Iniciar la sesión
include 'conexion.php'; // Incluir archivo de conexión a la base de datos

$error_message = ''; // Variable para almacenar el mensaje de error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consultar el usuario en la tabla 'login'
    $sql = "SELECT * FROM login WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si el usuario existe
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar si la cuenta está bloqueada
        if ($row['tiempo_bloqueo'] && strtotime($row['tiempo_bloqueo']) > time()) {
            $error_message = 'Cuenta bloqueada. Intenta de nuevo más tarde.';
        }
        // Verificar la contraseña
        elseif (password_verify($password, $row['password'])) {
            // Reiniciar intentos fallidos y tiempo de bloqueo
            $update = "UPDATE login SET intentos_fallidos = 0, tiempo_bloqueo = NULL WHERE id = ?";
            $stmt = $conn->prepare($update);
            $stmt->bind_param("i", $row['id']);
            $stmt->execute();

            // Guardar el nombre de usuario en la sesión
            $_SESSION['username'] = $username;
            $_SESSION['rut'] = $row['rut']; // Almacenar el rut en la sesión
            $_SESSION['role'] = $row['role']; // Guardar el rol del usuario
            $_SESSION['id'] = $row['id']; // ID del usuario


            // Redirigir según el rol del usuario
            if ($row['role'] === 'admin') {
                header("Location: admin-dashboard.html");
            } else {
                header("Location: AgendarHora.php");
            }
            exit();
        } else {
            // Si la contraseña es incorrecta
            $error_message = "Usuario o contraseña incorrecta.";
        }
    } else {
        // Si el usuario no existe
        $error_message = "Usuario o contraseña incorrecta.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- Incluir el HTML del formulario -->
<?php include 'login3.html'; ?>




