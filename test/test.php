<?php

/*
require_once 'socios.php';

// Crear un nuevo socio
$socio = new Socio(
    1, // ID de cooperativa (ajusta según tus datos)
    "Juan Pérez",
    "51234567",
    "099123456",
    "juan@example.com",
    "2025-10-20"
);
$socio->guardar();

echo "Socio creado con ID: " . $socio->getId() . "<br>";

// Buscar socio por ID
$encontrado = Socio::buscarPorId($socio->getId());
if ($encontrado) {
    echo "Socio encontrado: " . $encontrado->getNombre() . "<br>";
}

// Actualizar datos
$encontrado->setTelefono("098654321");
$encontrado->guardar();
echo "Socio actualizado.<br>";

// Mostrar todos los socios
$todos = Socio::recuperarTodos();
echo "<pre>";
print_r($todos);
echo "</pre>";

// Borrar el socio de prueba
// Socio::borrar($socio->getId());
// echo "Socio eliminado.<br>";

*/ //FIN TEST SOCIOS

/*

require_once '../cooperativas.php';

// Crear nueva cooperativa
$coop = new Cooperativa('Nueva Cooperativa', 'Av. Siempre Viva 742', 'Canelones', '091234567', 'nueva@coop.com');
$coop->guardar();
echo "Cooperativa guardada con ID: " . $coop->getId() . "<br>";

// Buscar por ID
$buscada = Cooperativa::buscarPorId($coop->getId());
if ($buscada) {
    echo "Encontrada: " . $buscada->getNombre() . "<br>";
}

// Listar todas
$todas = Cooperativa::obtenerTodas();
foreach ($todas as $fila) {
    echo $fila['id'] . " - " . $fila['nombre'] . "<br>";
}

*/ //fin test cooperativas

require_once '../proveedores.php';

// Crear un proveedor de prueba
$prov = new Proveedor('Proveedor Temporal', 12345678, '099888777', 'temporal@prov.com', 'Calle Falsa 456', 'Montevideo');
$prov->guardar();

echo "<strong>Proveedor creado con ID:</strong> " . $prov->getId() . "<br>";

// Buscar por ID
$buscado = Proveedor::buscarPorId($prov->getId());
if ($buscado) {
    echo "<strong>Proveedor encontrado:</strong> " . $buscado->getNombre() . "<br>";
}

// Listar todos los proveedores
echo "<strong>Todos los proveedores:</strong><br>";
$todos = Proveedor::obtenerTodos();
foreach ($todos as $fila) {
    echo $fila['id'] . " - " . $fila['nombre'] . "<br>";
}

/*
// Eliminar el proveedor de prueba
$prov->eliminar();
echo "<strong>Proveedor eliminado con ID:</strong> " . $prov->getId() . "<br>";

// Verificar eliminación
$verificar = Proveedor::buscarPorId($prov->getId());
if (!$verificar) {
    echo "<span style='color:green; font-weight:bold;'>✔ Eliminación confirmada: proveedor no encontrado.</span>";
} else {
    echo "<span style='color:red; font-weight:bold;'>✖ Error: el proveedor aún existe.</span>";
}
    */
?>



