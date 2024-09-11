<?php
include 'conexion.php'; // Incluir el archivo de conexión

$sql = "SELECT * FROM usuario";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Mostrar los resultados en formato tabla
  while($row = $result->fetch_assoc()) {
    echo "RUT: " . $row["rut"]. " - Nombre: " . $row["nombre"]. " " . $row["apellido"]. "<br>";
  }
} else {
  echo "0 resultados";
}
$conn->close();
?>
