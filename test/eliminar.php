<?php
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
?>