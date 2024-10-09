<?php
include 'conexion.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    
    // Verificar si el token es válido y no ha expirado
    $stmt = $conn->prepare('SELECT email FROM password_resets WHERE token = ? AND expiry > NOW()');
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];
        
        // Actualizar la contraseña en la base de datos
        $stmt = $conn->prepare('UPDATE usuarios SET password = ? WHERE email = ?');
        $stmt->bind_param('ss', $new_password, $email);
        $stmt->execute();
        
        // Eliminar el token de la base de datos
        $stmt = $conn->prepare('DELETE FROM password_resets WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        
        echo "Contraseña restablecida con éxito.";
    } else {
        echo "El enlace de recuperación no es válido o ha expirado.";
    }
}
?>
