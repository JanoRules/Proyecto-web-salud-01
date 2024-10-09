<?php
include 'conexion.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    
    // Verificar si el correo existe en la base de datos
    $stmt = $conn->prepare('SELECT * FROM usuarios WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Generar un token único
        $token = bin2hex(random_bytes(50));
        
        // Guardar el token y su fecha de expiración (ej. 1 hora)
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $stmt = $conn->prepare('INSERT INTO password_resets (email, token, expiry) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $email, $token, $expiry);
        $stmt->execute();
        
        // Enviar el enlace de recuperación al correo
        $resetLink = "https://tu-dominio.com/restablecer.html?token=$token";
        $subject = "Recuperación de contraseña";
        $message = "Haz clic en el siguiente enlace para restablecer tu contraseña: $resetLink";
        $headers = "From: no-reply@tu-dominio.com";
        
        if (mail($email, $subject, $message, $headers)) {
            echo "Se ha enviado un correo con el enlace de recuperación.";
        } else {
            echo "Error al enviar el correo.";
        }
    } else {
        echo "No se encontró ninguna cuenta con ese correo.";
    }
}
?>
