<?php
// Conexión a la base de datos (adapta los valores según tu configuración)
$conn = new mysqli("localhost", "usuario", "contraseña", "nombre_basedatos");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener los insumos de limpieza
$sql = "SELECT il.id, il.nombre, il.stock, il.unidad, p.nombre as proveedor 
        FROM insumos_limpieza il
        LEFT JOIN proveedores p ON il.id_proveedor = p.id";
$result = $conn->query($sql);

// Crear un array para almacenar los insumos de limpieza
$insumos = array();

// Recorrer los resultados y agregarlos al array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $insumos[] = $row;
    }
}

// Devolver los insumos de limpieza como respuesta JSON
header('Content-Type: application/json');
echo json_encode(array('success' => true, 'insumos' => $insumos));

// Cerrar la conexión a la base de datos
$conn->close();
?>