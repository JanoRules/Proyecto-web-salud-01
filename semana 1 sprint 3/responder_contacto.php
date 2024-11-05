<?php
require 'conexion.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Obtener los datos del contacto
    $query = "SELECT email, descripcion FROM contacto WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($email, $mensaje);
    $stmt->fetch();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $respuesta = $_POST['respuesta'];
    $destinatario = $_POST['email'];

    // Enviar correo al usuario
    mail($destinatario, "Respuesta a su mensaje", $respuesta);
    echo "Respuesta enviada al usuario con éxito.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Responder Mensaje</title></head>
<body>
    <h2>Responder a Mensaje de Contacto</h2>
    <form method="POST">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <p>Mensaje del Usuario: <?php echo htmlspecialchars($mensaje); ?></p>
        <label for="respuesta">Escribe tu respuesta:</label>
        <textarea name="respuesta" rows="4" cols="50"></textarea><br><br>
        <button type="submit">Enviar Respuesta</button>
    </form>
</body>
</html>
