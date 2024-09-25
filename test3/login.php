<?php
include 'conexion.php'; // Incluir archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consultar el usuario en la tabla 'login'
    $sql = "SELECT * FROM login WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            // Si la contraseña es correcta, redirigir a 'websalud.html'
            header("Location: websalud.html");
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    $conn->close();
}
?>
