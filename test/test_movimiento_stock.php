<?php
require_once '../movimientos_stock.php';
// require_once 'config/conexion.php';

// Paso 1: Verificamos si existe el ítem de stock que vamos a usar
$conexion = new Conexion();
$consulta = $conexion->prepare("SELECT id, nombre, cantidad FROM stock LIMIT 10");
$consulta->execute();
$stock = $consulta->fetch(PDO::FETCH_ASSOC);

if (!$stock) {
    echo "No hay registros en la tabla 'stock'. Insertando uno de prueba...\n";
    $insert = $conexion->prepare("INSERT INTO stock (nombre, unidad, cantidad, descripcion) VALUES ('Pala', 'unidad', 0, 'Pala de mano')");
    $insert->execute();
    $stock_id = $conexion->lastInsertId();
    $stock_nombre = 'Pala';
    $cantidad_inicial = 0;
} else {
    $stock_id = $stock['id'];
    $stock_nombre = $stock['nombre'];
    $cantidad_inicial = $stock['cantidad'];
}

echo "Probando con el material: {$stock_nombre} (Stock inicial: {$cantidad_inicial})\n";

// Paso 2: Creamos un movimiento de stock (entrada o salida)
$movimiento = new MovimientoStock();
$movimiento->setStockId($stock_id);
$movimiento->setTipoMovimiento('entrada'); // opciones: 'entrada', 'salida', 'devolucion'
$movimiento->setCantidad(5); // cantidad a sumar o restar
$movimiento->setResponsable('Juan Pérez');
$movimiento->setMotivo('Compra adicional de materiales');
$movimiento->setFecha(date('Y-m-d'));

// Paso 3: Guardamos el movimiento (esto también actualiza el stock automáticamente)
$movimiento->guardar();

echo "Movimiento registrado correctamente (ID: " . $movimiento->getId() . ")\n";

// Paso 4: Consultamos el stock actualizado
$consulta = $conexion->prepare("SELECT cantidad FROM stock WHERE id = :id");
$consulta->bindParam(':id', $stock_id);
$consulta->execute();
$nuevo_stock = $consulta->fetchColumn();

echo "Nuevo stock de '{$stock_nombre}': {$nuevo_stock}\n";

/*
// Paso 5: Listar todos los movimientos
echo "\n Lista de movimientos registrados:\n";
$movimientos = MovimientoStock::listar();
foreach ($movimientos as $m) {
    echo "- [{$m['id']}] {$m['tipo_movimiento']} de {$m['cantidad']} unidades, responsable: {$m['responsable']} ({$m['fecha']})\n";
}
*/
