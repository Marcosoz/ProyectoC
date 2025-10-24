<?php

/* // Inicio test eliminar cooperativas
require_once '../cooperativas.php';

// Buscar la cooperativa con ID 3
$coop = Cooperativa::buscarPorId(4);

if ($coop) {
    // Eliminarla
    $coop->eliminar();
    echo "Cooperativa eliminada correctamente.";
} else {
    echo "No se encontró ninguna cooperativa con ese ID.";
}

*/ // Fin test eliminar cooperativas


require_once '../ingresos.php';

//ID del ingreso que quiero eliminar
$idEliminar = 4; // Manual

// Buscar el ingreso
$ingreso = Ingreso::obtenerPorId($idEliminar);

if ($ingreso) {
    $ingreso->eliminar();
    echo "Ingreso con ID {$idEliminar} eliminado correctamente.";
} else {
    echo "No se encontro un registro con ese ID";
}
