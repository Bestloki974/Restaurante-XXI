<?php
// Conexión a la base de datos (adapta los valores según tu configuración)
$conn = new mysqli("localhost", "usuario", "contraseña", "nombre_basedatos");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los datos del insumo de limpieza desde la solicitud POST
$id = $_POST['id'] ?? null;
$nombre = $_POST['nombre'];
$stock = $_POST['stock'];
$unidad = $_POST['unidad'];
$idProveedor = $_POST['id_proveedor'];

// Consulta para guardar o actualizar el insumo de limpieza
if ($id) {
    // Actualizar insumo de limpieza existente
    $sql = "UPDATE insumos_limpieza SET nombre = ?, stock = ?, unidad = ?, id_proveedor = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisii", $nombre, $stock, $unidad, $idProveedor, $id);
} else {
    // Insertar nuevo insumo de limpieza
    $sql = "INSERT INTO insumos_limpieza (nombre, stock, unidad, id_proveedor) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisi", $nombre, $stock, $unidad, $idProveedor);
}

// Ejecutar la consulta
if ($stmt->execute()) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false, 'error' => 'Error al guardar el insumo de limpieza'));
}

// Cerrar la conexión a la base de datos
$stmt->close();
$conn->close();
?>