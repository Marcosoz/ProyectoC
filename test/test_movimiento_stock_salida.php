<?php
require_once '../movimientos_stock.php';
// require_once 'Conexion.php';

// Paso 1: Obtener un ítem de stock existente
$conexion = new Conexion();
$consulta = $conexion->prepare("SELECT id, nombre, cantidad FROM stock LIMIT 1");
$consulta->execute();
$stock = $consulta->fetch(PDO::FETCH_ASSOC);

if (!$stock) {
    echo "No hay materiales en la tabla 'stock'. Inserta al menos uno antes de probar.\n";
    exit;
}

$stock_id = $stock['id'];
$stock_nombre = $stock['nombre'];
$cantidad_actual = $stock['cantidad'];

echo "Material: {$stock_nombre} (Stock actual: {$cantidad_actual})\n";

// Paso 2: Definir cantidad a retirar
$cantidad_salida = 3;

if ($cantidad_actual < $cantidad_salida) {
    echo "No hay suficiente stock para retirar {$cantidad_salida} unidades.\n";
    exit;
}

// Paso 3: Crear el movimiento de salida
$movimiento = new MovimientoStock(
    $stock_id,
    'salida',
    $cantidad_salida,
    'Pedro López',
    'Retiro de herramientas para jornada laboral',
    date('Y-m-d')
);

// Paso 4: Guardar el movimiento (actualiza automáticamente el stock)
$movimiento->guardar();

echo "Movimiento de salida registrado correctamente (ID: " . $movimiento->getId() . ")\n";

// Paso 5: Consultar stock actualizado
$consulta = $conexion->prepare("SELECT cantidad FROM stock WHERE id = :id");
$consulta->bindParam(':id', $stock_id);
$consulta->execute();
$nuevo_stock = $consulta->fetchColumn();

echo "Nuevo stock de '{$stock_nombre}': {$nuevo_stock}\n";

// Paso 6: Listar los movimientos recientes
echo "\n Movimientos registrados:\n";
$movimientos = MovimientoStock::listar();
foreach ($movimientos as $m) {
    echo "- [{$m['id']}] {$m['tipo_movimiento']} de {$m['cantidad']} unidades, responsable: {$m['responsable']} ({$m['fecha']})\n";
}
