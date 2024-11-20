<?php
// Conexión a la base de datos (adapta los valores según tu configuración)
$conn = new mysqli("localhost", "usuario", "contraseña", "nombre_basedatos");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el ID del insumo de limpieza desde la URL
$id = $_GET['id'];

// Consulta para obtener el insumo de limpieza por su ID
$sql = "SELECT * FROM insumos_limpieza WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontró el insumo de limpieza
if ($result->num_rows == 1) {
    $insumo = $result->fetch_assoc();
    echo json_encode(array('success' => true, 'insumo' => $insumo));
} else {
    echo json_encode(array('success' => false, 'error' => 'Insumo de limpieza no encontrado'));
}

// Cerrar la conexión a la base de datos
$stmt->close();
$conn->close();
?>